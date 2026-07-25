<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PublicationStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
final class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => PublicationStatus::Draft,
            'sort_order' => 0,
            'is_featured' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => [
            'status' => PublicationStatus::Published,
            'published_at' => now()->subDay(),
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (): array => [
            'status' => PublicationStatus::Scheduled,
            'published_at' => now()->addDay(),
        ]);
    }

    /**
     * @param  array<string, array<string, mixed>>  $translations
     */
    public function withTranslations(array $translations): static
    {
        return $this->afterCreating(function (Project $project) use ($translations): void {
            $project->setTranslations($translations);
        });
    }
}
