<?php

declare(strict_types=1);

use App\Models\Project;
use Illuminate\Database\QueryException;

it('rejects two projects sharing a slug in the same locale', function (): void {
    $first = Project::factory()->create();
    $first->setTranslations(['en' => ['title' => 'First', 'slug' => 'shared-slug', 'excerpt' => 'x']]);

    $second = Project::factory()->create();

    expect(fn () => $second->setTranslations(['en' => ['title' => 'Second', 'slug' => 'shared-slug', 'excerpt' => 'x']]))
        ->toThrow(QueryException::class);
});

it('allows the same slug string across different locales', function (): void {
    $project = Project::factory()->create();

    $project->setTranslations([
        'en' => ['title' => 'Shared', 'slug' => 'shared', 'excerpt' => 'x'],
        'fa' => ['title' => 'مشترک', 'slug' => 'shared', 'excerpt' => 'x'],
    ]);

    expect($project->translations()->count())->toBe(2);
});
