<?php

declare(strict_types=1);

use App\Filament\Resources\NotFoundVisitResource;
use App\Filament\Resources\NotFoundVisitResource\Pages\ListNotFoundVisits;
use App\Models\NotFoundVisit;
use App\Models\Redirect;
use App\Models\Setting;
use App\Models\User;
use App\Services\Redirects\NotFoundMonitor;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

beforeEach(function (): void {
    RateLimiter::clear('seo-404-monitor');
});

function enable404Monitoring(): void
{
    Setting::updateOrCreate(['key' => 'seo_404_monitor_enabled'], ['group' => 'seo', 'value' => ['value' => true], 'is_translatable' => false]);
}

it('is disabled by default and records public paths without query strings when enabled', function (): void {
    $this->get('/en/missing?email=private@example.com')->assertNotFound();
    expect(NotFoundVisit::count())->toBe(0);
    enable404Monitoring();
    $this->get('/en/missing?email=private@example.com')->assertNotFound();
    $this->get('/en/missing?token=another-secret')->assertNotFound();
    $visit = NotFoundVisit::firstOrFail();
    expect($visit->path)->toBe('en/missing')->and($visit->hits)->toBe(2)
        ->and(json_encode($visit->toArray()))->not->toContain('private@example.com', 'another-secret');
});

it('ignores private paths, assets, post requests and JSON traffic', function (): void {
    enable404Monitoring();
    $monitor = app(NotFoundMonitor::class);
    foreach ([Request::create('/admin/missing'), Request::create('/en/missing.png'), Request::create('/en/missing', 'POST'), Request::create('/en/missing', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json'])] as $request) {
        $monitor->record($request);
    }
    expect(NotFoundVisit::count())->toBe(0);
});

it('only allows administrators to view reports', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $editor = User::factory()->create()->assignRole('editor');
    $this->actingAs($editor)->get(NotFoundVisitResource::getUrl())->assertForbidden();
});

it('lets an administrator create a validated redirect from a report', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    enable404Monitoring();
    $this->get('/en/old')->assertNotFound();
    $visit = NotFoundVisit::firstOrFail();
    Livewire::actingAs($admin)->test(ListNotFoundVisits::class)
        ->callTableAction('create_redirect', $visit, ['destination_path' => 'en/new', 'status_code' => 301])
        ->assertHasNoTableActionErrors();
    $this->assertDatabaseHas('redirects', ['source_path' => 'en/old', 'destination_path' => 'en/new', 'is_active' => true]);
    $this->get('/en/old')->assertRedirect(url('/en/new'));
    expect($visit->fresh()->hits)->toBe(1);
});

it('rejects redirect loops created from a report', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    enable404Monitoring();
    $this->get('/en/old')->assertNotFound();
    $visit = NotFoundVisit::firstOrFail();
    Redirect::create(['source_path' => 'en/new', 'destination_path' => 'en/old', 'status_code' => 301, 'is_active' => true]);
    Livewire::actingAs($admin)->test(ListNotFoundVisits::class)
        ->callTableAction('create_redirect', $visit, ['destination_path' => 'en/new', 'status_code' => 301])
        ->assertHasTableActionErrors(['destination_path']);
    expect(Redirect::where('source_path', 'en/old')->exists())->toBeFalse();
});

it('rate limits writes without changing the 404 response', function (): void {
    enable404Monitoring();
    for ($i = 0; $i < 120; $i++) {
        RateLimiter::hit('seo-404-monitor', 60);
    }
    $this->get('/en/missing')->assertNotFound();
    expect(NotFoundVisit::count())->toBe(0);
});

it('prunes reports not seen for 30 days when the scheduled task runs', function (): void {
    $old = NotFoundVisit::create(['path_hash' => hash('sha256', 'en/old'), 'path' => 'en/old', 'hits' => 1,
        'first_seen_at' => now()->subDays(40), 'last_seen_at' => now()->subDays(31)]);
    $recent = NotFoundVisit::create(['path_hash' => hash('sha256', 'en/recent'), 'path' => 'en/recent', 'hits' => 1,
        'first_seen_at' => now()->subDays(40), 'last_seen_at' => now()->subDays(2)]);
    $event = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events())->first(fn ($event) => $event->description === 'sahra:prune-404-reports');
    expect($event)->not->toBeNull();
    $event->run(app());
    expect(NotFoundVisit::whereKey($old->getKey())->exists())->toBeFalse()
        ->and(NotFoundVisit::whereKey($recent->getKey())->exists())->toBeTrue();
});

it('bounds new paths while retaining counts for existing reports', function (): void {
    enable404Monitoring();
    $rows = [];
    $timestamp = now()->toDateTimeString();
    for ($i = 0; $i < 10000; $i++) {
        $path = "en/missing-{$i}";
        $rows[] = ['path_hash' => hash('sha256', $path), 'path' => $path, 'hits' => 1, 'first_seen_at' => $timestamp, 'last_seen_at' => $timestamp];
        if (count($rows) === 100) {
            \Illuminate\Support\Facades\DB::table('not_found_visits')->insert($rows);
            $rows = [];
        }
    }
    $monitor = app(NotFoundMonitor::class);
    $monitor->record(Request::create('/en/new-path'));
    $monitor->record(Request::create('/en/missing-1'));
    expect(NotFoundVisit::count())->toBe(10000)
        ->and(NotFoundVisit::where('path', 'en/missing-1')->value('hits'))->toBe(2)
        ->and(NotFoundVisit::where('path', 'en/new-path')->exists())->toBeFalse();
});

it('does not overwrite an existing redirect when creating one from a report', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $visit = NotFoundVisit::create(['path_hash' => hash('sha256', 'en/old'), 'path' => 'en/old', 'hits' => 1,
        'first_seen_at' => now(), 'last_seen_at' => now()]);
    Redirect::create(['source_path' => 'en/old', 'destination_path' => 'en/original', 'status_code' => 301, 'is_active' => true]);
    Livewire::actingAs($admin)->test(ListNotFoundVisits::class)
        ->callTableAction('create_redirect', $visit, ['destination_path' => 'en/other', 'status_code' => 301])
        ->assertHasNoTableActionErrors();
    expect(Redirect::where('source_path', 'en/old')->value('destination_path'))->toBe('en/original');
});
