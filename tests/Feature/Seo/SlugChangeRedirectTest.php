<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\Redirect;
use App\Models\Setting;
use App\Support\SiteSettings;

function setSlugSetting(string $key, mixed $value): void
{
    Setting::updateOrCreate(['key' => $key], ['group' => 'seo', 'value' => ['value' => $value], 'is_translatable' => false]);
    SiteSettings::flush();
}

function renameProject(): Project
{
    $project = Project::factory()->create();
    $project->setTranslations(['en' => ['title' => 'P', 'slug' => 'old-slug', 'excerpt' => 'x']]);
    $project->setTranslations(['en' => ['title' => 'P', 'slug' => 'new-slug', 'excerpt' => 'x']]);

    return $project;
}

it('redirects the old slug with 301 by default', function (): void {
    renameProject();

    $r = Redirect::query()->where('source_path', 'en/work/old-slug')->firstOrFail();

    expect($r->destination_path)->toBe('en/work/new-slug')->and($r->status_code)->toBe(301);
});

it('uses the configured status code', function (): void {
    setSlugSetting('slug_auto_redirect_status', '303');
    renameProject();

    expect(Redirect::query()->where('source_path', 'en/work/old-slug')->value('status_code'))->toBe(303);
});

it('creates no redirect when the option is off', function (): void {
    setSlugSetting('slug_auto_redirect', false);
    renameProject();

    expect(Redirect::query()->count())->toBe(0);
});

it('serves stored redirects before routing', function (): void {
    Redirect::create(['source_path' => '/en/work/gone/', 'destination_path' => 'en/work', 'status_code' => 308, 'is_active' => true]);

    $this->get('/en/work/gone')->assertStatus(308)->assertRedirect(url('/en/work'));
});
