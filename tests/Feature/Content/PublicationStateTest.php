<?php

declare(strict_types=1);

use App\Models\Project;

it('lists only published projects with a past publish date', function (): void {
    $published = Project::factory()->published()->create();
    $published->setTranslations(['en' => ['title' => 'Published one', 'slug' => 'published-one', 'excerpt' => 'x']]);

    $draft = Project::factory()->create();
    $draft->setTranslations(['en' => ['title' => 'Draft one', 'slug' => 'draft-one', 'excerpt' => 'x']]);

    $scheduled = Project::factory()->scheduled()->create();
    $scheduled->setTranslations(['en' => ['title' => 'Scheduled one', 'slug' => 'scheduled-one', 'excerpt' => 'x']]);

    $visible = Project::query()->published()->pluck('id');

    expect($visible)->toContain($published->id)
        ->not->toContain($draft->id)
        ->not->toContain($scheduled->id);
});

it('does not resolve a draft project via route model binding', function (): void {
    $draft = Project::factory()->create();
    $draft->setTranslations(['en' => ['title' => 'Hidden', 'slug' => 'hidden-project', 'excerpt' => 'x']]);

    $this->get('/en/work/hidden-project')->assertNotFound();
});

it('resolves a published project only under its own locale slug', function (): void {
    $project = Project::factory()->published()->create();
    $project->setTranslations([
        'en' => ['title' => 'English title', 'slug' => 'english-slug', 'excerpt' => 'x'],
        'fa' => ['title' => 'عنوان فارسی', 'slug' => 'عنوان-فارسی', 'excerpt' => 'x'],
    ]);

    $this->get('/en/work/english-slug')->assertOk();

    // The English slug must not resolve under the Persian prefix.
    $this->get('/fa/work/english-slug')->assertNotFound();

    $this->get('/fa/work/عنوان-فارسی')->assertOk();
});

it('promotes a due scheduled project via the publish command', function (): void {
    $project = Project::factory()->create([
        'status' => \App\Enums\PublicationStatus::Scheduled,
        'published_at' => now()->subMinute(),
    ]);
    $project->setTranslations(['en' => ['title' => 'Due', 'slug' => 'due-project', 'excerpt' => 'x']]);

    $this->artisan('sahra:publish-scheduled')->assertSuccessful();

    expect($project->fresh()->status)->toBe(\App\Enums\PublicationStatus::Published);
});
