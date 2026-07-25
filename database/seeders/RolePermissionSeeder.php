<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Seeds roles, permissions and the initial admin account.
 *
 * Permission naming matches App\Policies\BasePolicy:
 *   view_any_{resource}, view_{resource}, create_{resource},
 *   update_{resource}, update_any_{resource}, delete_{resource},
 *   delete_any_{resource}, restore_{resource}
 *
 * Roles:
 *   admin  — every permission
 *   editor — content CRUD; no users, settings, redirects or bulk deletion
 */
final class RolePermissionSeeder extends Seeder
{
    /**
     * Resources an editor may fully manage.
     *
     * @var array<int, string>
     */
    private const EDITOR_RESOURCES = [
        'page',
        'project',
        'service',
        'post',
        'post_category',
        'post_tag',
        'industry',
        'team_member',
        'testimonial',
        'faq',
        'client',
        'contact_submission',
    ];

    /**
     * Admin-only resources.
     *
     * @var array<int, string>
     */
    private const ADMIN_RESOURCES = [
        'user',
        'menu',
        'social_link',
        'newsletter_subscription',
        'redirect',
    ];

    /**
     * @var array<int, string>
     */
    private const ACTIONS = [
        'view_any',
        'view',
        'create',
        'update',
        'update_any',
        'delete',
        'delete_any',
        'restore',
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $all = array_merge(self::EDITOR_RESOURCES, self::ADMIN_RESOURCES);

        $permissions = [];

        foreach ($all as $resource) {
            foreach (self::ACTIONS as $action) {
                $permissions[] = "{$action}_{$resource}";
            }
        }

        foreach ($permissions as $name) {
            Permission::findOrCreate($name, 'web');
        }

        $admin = Role::findOrCreate('admin', 'web');
        $admin->syncPermissions($permissions);

        $editorPermissions = [];

        foreach (self::EDITOR_RESOURCES as $resource) {
            foreach (self::ACTIONS as $action) {
                // Editors do not get bulk deletion.
                if ($action === 'delete_any') {
                    continue;
                }

                $editorPermissions[] = "{$action}_{$resource}";
            }
        }

        $editor = Role::findOrCreate('editor', 'web');
        $editor->syncPermissions($editorPermissions);

        $this->createInitialAdmin();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * Creates the first admin only when no users exist, so re-running the
     * seeder on a live database never resets a real account's password.
     */
    private function createInitialAdmin(): void
    {
        if (User::query()->exists()) {
            $this->command?->info('Users already exist — skipping initial admin.');

            return;
        }

        $email = env('ADMIN_EMAIL', 'admin@sahra.example');
        $password = env('ADMIN_PASSWORD', 'ChangeMe!2026');

        $user = User::create([
            'name' => env('ADMIN_NAME', 'Sahra Admin'),
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        $this->command?->warn("Initial admin created: {$email}");
        $this->command?->warn('Change this password immediately after first login.');
    }
}
