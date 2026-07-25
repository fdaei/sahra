<?php

declare(strict_types=1);

use App\Models\ContactSubmission;

it('stores a valid contact submission', function (): void {
    $response = $this->from('/en/contact')->post('/en/contact', [
        'name' => 'Jane Doe',
        'brand_name' => 'Doe Studio',
        'phone' => '+968 7781 1213',
        'message' => 'Hello, I would like to talk about branding.',
        'form_started_at' => (now()->subSeconds(10)->timestamp) * 1000,
    ]);

    $response->assertRedirect('/en/contact');
    $response->assertSessionHas('success');

    expect(ContactSubmission::query()->where('name', 'Jane Doe')->exists())->toBeTrue();
});

it('rejects a submission with neither phone nor email', function (): void {
    $response = $this->from('/en/contact')->post('/en/contact', [
        'name' => 'Jane Doe',
        'message' => 'Hello',
        'form_started_at' => (now()->subSeconds(10)->timestamp) * 1000,
    ]);

    $response->assertSessionHasErrors('phone');
});

it('silently rejects a honeypot-filled submission', function (): void {
    $response = $this->from('/en/contact')->post('/en/contact', [
        'name' => 'Bot',
        'phone' => '+968 1234 5678',
        'website' => 'http://spam.example',
    ]);

    $response->assertSessionHasErrors('website');
    expect(ContactSubmission::query()->where('name', 'Bot')->exists())->toBeFalse();
});

it('rejects a submission filled faster than a human plausibly could', function (): void {
    $response = $this->from('/en/contact')->post('/en/contact', [
        'name' => 'Speedy',
        'phone' => '+968 1234 5678',
        'form_started_at' => now()->timestamp * 1000, // 0 seconds elapsed
    ]);

    $response->assertSessionHasErrors('name');
});
