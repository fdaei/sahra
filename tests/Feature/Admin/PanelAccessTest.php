<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function (): void {
    $this->seed(RolePermissionSeeder::class);
});

it('blocks guests from the admin panel', function (): void {
    foreach (['/admin', '/admin/language/fa', '/admin/not-found-logs'] as $path) {
        $response = $this->get($path)->assertRedirect('/admin/login')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertHeader('Referrer-Policy', 'no-referrer');
        expect($response->headers->get('Cache-Control'))->toContain('no-store');
    }
});

it('blocks an authenticated user without a panel role', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden()
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    $this->get('/admin/language/fa')->assertForbidden();
});

it('allows an editor into the panel', function (): void {
    $user = User::factory()->create();
    $user->assignRole('editor');

    $this->actingAs($user)->get('/admin')->assertOk();
});

it('allows an admin into the panel', function (): void {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $this->actingAs($user)->get('/admin')->assertOk();
});
