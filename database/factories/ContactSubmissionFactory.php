<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SubmissionStatus;
use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactSubmission>
 */
final class ContactSubmissionFactory extends Factory
{
    protected $model = ContactSubmission::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'brand_name' => $this->faker->company(),
            'phone' => '+968'.$this->faker->numerify('########'),
            'email' => $this->faker->safeEmail(),
            'message' => $this->faker->paragraph(),
            'service_ids' => [],
            'service_titles' => [],
            'status' => SubmissionStatus::New,
            'locale' => 'en',
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
