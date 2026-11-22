<?php

declare(strict_types=1);

use App\Filament\Resources\RedirectResource\Pages\CreateRedirect;
use App\Models\Redirect;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
    $this->seed(RolePermissionSeeder::class);
    $this->admin = User::factory()->create()->assignRole('admin');
});

it('rejects duplicate source paths after normalization', function (): void {
    Redirect::create(['source_path' => 'en/old', 'destination_path' => 'en/new', 'status_code' => 301, 'is_active' => true]);
    Livewire::actingAs($this->admin)->test(CreateRedirect::class)
        ->fillForm(['source_path' => '/en/%6Fld/', 'destination_path' => 'en/other', 'status_code' => 301, 'is_active' => true])
        ->call('create')->assertHasFormErrors(['source_path' => 'unique']);
    expect(Redirect::count())->toBe(1);
});

it('rejects direct and indirect redirect loops on save', function (): void {
    Redirect::create(['source_path' => 'en/second', 'destination_path' => 'en/third', 'status_code' => 301, 'is_active' => true]);
    Redirect::create(['source_path' => 'en/third', 'destination_path' => 'en/first', 'status_code' => 301, 'is_active' => true]);
    foreach (['en/first', 'en/second', 'https://seo.example/en/first'] as $destination) {
        Livewire::actingAs($this->admin)->test(CreateRedirect::class)
            ->fillForm(['source_path' => 'en/first', 'destination_path' => $destination, 'status_code' => 301, 'is_active' => true])
            ->call('create')->assertHasFormErrors(['destination_path']);
    }
    expect(Redirect::count())->toBe(2);
});

it('skips an existing loop at request time instead of issuing endless redirects', function (): void {
    Redirect::create(['source_path' => 'en/a', 'destination_path' => 'en/b', 'status_code' => 301, 'is_active' => true]);
    Redirect::create(['source_path' => 'en/b', 'destination_path' => 'en/a', 'status_code' => 301, 'is_active' => true]);
    $this->get('/en/a')->assertNotFound();
    expect(Redirect::where('source_path', 'en/a')->value('hits'))->toBe(0);
});

it('allows an external destination that happens to have the same path', function (): void {
    Redirect::create(['source_path' => 'en/a', 'destination_path' => 'https://other.example/en/a', 'status_code' => 301, 'is_active' => true]);
    $this->get('/en/a')->assertRedirect('https://other.example/en/a');
});

it('rejects unsupported destinations and saves a valid one', function (): void {
    foreach (['javascript:alert(1)', '//other.example/path', 'en/new?secret=1', 'https://user:pass@other.example/path'] as $destination) {
        Livewire::actingAs($this->admin)->test(CreateRedirect::class)
            ->fillForm(['source_path' => 'en/old', 'destination_path' => $destination, 'status_code' => 301, 'is_active' => true])
            ->call('create')->assertHasFormErrors(['destination_path']);
    }
    Livewire::actingAs($this->admin)->test(CreateRedirect::class)
        ->fillForm(['source_path' => '/en/old/', 'destination_path' => 'en/new', 'status_code' => 301, 'is_active' => true])
        ->call('create')->assertHasNoFormErrors();
    $this->assertDatabaseHas('redirects', ['source_path' => 'en/old', 'destination_path' => 'en/new']);
});

it('continues to support redirects to the site root', function (): void {
    Livewire::actingAs($this->admin)->test(CreateRedirect::class)
        ->fillForm(['source_path' => 'en/old', 'destination_path' => '/', 'status_code' => 301, 'is_active' => true])
        ->call('create')->assertHasNoFormErrors();
    $this->assertDatabaseHas('redirects', ['source_path' => 'en/old', 'destination_path' => '']);
    $this->get('/en/old')->assertRedirect(url('/'));
});

it('trims external destinations before storing them', function (): void {
    Redirect::create(['source_path' => 'en/a', 'destination_path' => ' https://other.example/path ', 'status_code' => 301, 'is_active' => true]);
    $this->get('/en/a')->assertRedirect('https://other.example/path');
});

it('prevents an inactive redirect from being activated if that creates a loop', function (): void {
    Redirect::create(['source_path' => 'en/a', 'destination_path' => 'en/b', 'status_code' => 301, 'is_active' => true]);
    $redirect = Redirect::create(['source_path' => 'en/b', 'destination_path' => 'en/a', 'status_code' => 301, 'is_active' => false]);
    Livewire::actingAs($this->admin)->test(\App\Filament\Resources\RedirectResource\Pages\EditRedirect::class, ['record' => $redirect->getKey()])
        ->fillForm(['is_active' => true])->call('save')->assertHasFormErrors(['destination_path']);
    expect($redirect->refresh()->is_active)->toBeFalse();
});

it('rejects unsupported redirect status codes', function (): void {
    Livewire::actingAs($this->admin)->test(CreateRedirect::class)
        ->fillForm(['source_path' => 'en/a', 'destination_path' => 'en/b', 'status_code' => 200, 'is_active' => true])
        ->call('create')->assertHasFormErrors(['status_code']);
    expect(Redirect::count())->toBe(0);
});

it('detects loops through a previously stored root redirect', function (): void {
    Redirect::create(['source_path' => '/', 'destination_path' => 'en/a', 'status_code' => 301, 'is_active' => true]);
    Redirect::create(['source_path' => 'en/a', 'destination_path' => '/', 'status_code' => 301, 'is_active' => true]);
    $this->get('/en/a')->assertNotFound();
});

it('ignores an invalid status code already stored in the database', function (): void {
    Redirect::create(['source_path' => 'en/a', 'destination_path' => 'en/b', 'status_code' => 200, 'is_active' => true]);
    $this->get('/en/a')->assertNotFound();
});
