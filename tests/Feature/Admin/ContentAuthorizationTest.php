<?php

declare(strict_types=1);

use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function (): void {
    $this->seed(RolePermissionSeeder::class);
});

it('allows an editor to view the projects resource', function (): void {
    $user = User::factory()->create();
    $user->assignRole('editor');

    $this->actingAs($user)->get('/admin/projects')->assertOk();
});

it('prevents a user from deleting their own account', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    expect($admin->can('delete', $admin))->toBeFalse();
});

it('allows an admin to delete a different user', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $other = User::factory()->create();

    expect($admin->can('delete', $other))->toBeTrue();
});

it('denies force-delete to a non-admin editor', function (): void {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $project = Project::factory()->create();

    expect($editor->can('forceDelete', $project))->toBeFalse();
});
