<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function (): void {
    $this->seed(RolePermissionSeeder::class);
});

it('blocks guests from the admin panel', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

it('blocks an authenticated user without a panel role', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
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
