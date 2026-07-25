<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Order matters:
 *   1. roles/permissions + admin user (posts need an author)
 *   2. taxonomies (projects and posts reference them)
 *   3. services (projects attach to them)
 *   4. pages and sections
 *   5. projects and posts
 *   6. settings and navigation (menu items link to routes)
 *   7. team, testimonials, FAQs, clients
 */
final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            TaxonomySeeder::class,
            ServiceSeeder::class,
            PageSeeder::class,
            ProjectSeeder::class,
            PostSeeder::class,
            SiteSettingsSeeder::class,
            ContentSeeder::class,
        ]);
    }
}
