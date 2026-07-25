<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PublicationStatus;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => PublicationStatus::Draft,
            'reading_minutes' => 1,
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
        return $this->afterCreating(function (Post $post) use ($translations): void {
            $post->setTranslations($translations);
        });
    }
}
