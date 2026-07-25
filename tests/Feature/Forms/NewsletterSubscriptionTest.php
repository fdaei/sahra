<?php

declare(strict_types=1);

use App\Models\NewsletterSubscription;

it('subscribes a new email address', function (): void {
    $response = $this->from('/en')->post('/en/newsletter', [
        'email' => 'lead@example.com',
        'source' => 'home',
    ]);

    $response->assertRedirect('/en');
    expect(NewsletterSubscription::query()->where('email', 'lead@example.com')->exists())->toBeTrue();
});

it('reactivates a previously unsubscribed address without creating a duplicate', function (): void {
    NewsletterSubscription::factory()->create([
        'email' => 'returning@example.com',
        'unsubscribed_at' => now()->subMonth(),
    ]);

    $this->from('/en')->post('/en/newsletter', ['email' => 'returning@example.com']);

    expect(NewsletterSubscription::query()->where('email', 'returning@example.com')->count())->toBe(1);
    expect(NewsletterSubscription::query()->where('email', 'returning@example.com')->first()->isActive())->toBeTrue();
});
