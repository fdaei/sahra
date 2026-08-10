<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<NewsletterSubscription>
 */
final class NewsletterSubscriptionFactory extends Factory
{
    protected $model = NewsletterSubscription::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'locale' => 'en',
            'source' => 'home',
            'unsubscribe_token' => Str::random(64),
        ];
    }
}
