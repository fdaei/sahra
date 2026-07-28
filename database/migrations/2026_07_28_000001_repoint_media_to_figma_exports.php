<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Repoint entity media at the assets exported from Figma.
 *
 * The rows had been pointed at ad-hoc admin uploads (ULID filenames) which
 * were removed in favour of exporting the real artwork from the design file.
 * The paths below are the canonical ones the seeders use, so a fresh
 * `db:seed` and an existing database now agree.
 *
 * Source nodes (page `User interface`, 1:2):
 *   projects   1214:3933 grid, one IMAGE fill per `project post`
 *   services   I1323:7224/7226/7225/7227 → `img`
 *   posts      1419:9265 (big insight) + 1419:9267 / 9271 (small insights)
 *   clients    1419:9209–9214, exported as SVG
 *   testimonial I1419:9251;414:858
 *
 * Team portraits are deliberately untouched — those are real uploads.
 */
return new class extends Migration
{
    /** @var array<string, array<string, string|null>> */
    private const PROJECTS = [
        'baghche-branding' => ['cover_path' => 'projects/baghche.webp'],
        'kerman-motors' => ['cover_path' => 'projects/kerman-motors.webp'],
        'fakhar-clinic' => ['cover_path' => 'projects/fakhar-clinic.webp'],
        'plus-protein' => ['cover_path' => 'projects/plus-protein.webp'],
        'karsa-tourism' => ['cover_path' => 'projects/karsa-tourism.webp'],
        'cheshmeh-beauty' => ['cover_path' => 'projects/cheshmeh.webp'],
    ];

    /** @var array<int, string> */
    private const CLIENTS = [
        1 => 'clients/pars.svg',
        2 => 'clients/all-digitall.svg',
        3 => 'clients/baghche.svg',
        4 => 'clients/noora.svg',
        5 => 'clients/vanak.svg',
        6 => 'clients/tavakoli.svg',
    ];

    /** @var array<string, string> */
    private const POSTS = [
        'content-without-direction' => 'posts/brand-direction.webp',
        'social-media-growth-system' => 'posts/social-growth.webp',
    ];

    /** @var array<string, string> */
    private const SERVICES = [
        'branding' => 'services/branding.webp',
        'content-production' => 'services/content-production.webp',
        'marketing-design' => 'services/marketing-design.webp',
        'social-media-support' => 'services/social-media-support.webp',
    ];

    public function up(): void
    {
        foreach (self::PROJECTS as $slug => $columns) {
            $id = DB::table('project_translations')
                ->where('locale', 'en')->where('slug', $slug)->value('project_id');

            if ($id !== null) {
                DB::table('projects')->where('id', $id)->update($columns);
            }
        }

        // The banner and before/after crops have no standalone export yet;
        // null keeps the templates from requesting a file that isn't there.
        DB::table('projects')->whereNotNull('banner_path')
            ->whereRaw("banner_path LIKE 'projects/01K%'")
            ->update(['banner_path' => null]);

        DB::table('projects')
            ->whereRaw("before_image_path LIKE 'projects/01K%' OR after_image_path LIKE 'projects/01K%'")
            ->update(['before_image_path' => null, 'after_image_path' => null]);

        foreach (self::CLIENTS as $id => $path) {
            DB::table('clients')->where('id', $id)->update(['logo_path' => $path]);
        }

        foreach (self::POSTS as $slug => $path) {
            $id = DB::table('post_translations')
                ->where('locale', 'en')->where('slug', $slug)->value('post_id');

            if ($id !== null) {
                DB::table('posts')->where('id', $id)->update(['cover_path' => $path]);
            }
        }

        foreach (self::SERVICES as $slug => $path) {
            $id = DB::table('service_translations')
                ->where('locale', 'en')->where('slug', $slug)->value('service_id');

            if ($id !== null) {
                DB::table('services')->where('id', $id)->update(['image_path' => $path]);
            }
        }

        DB::table('testimonials')->where('id', 1)
            ->update(['avatar_path' => 'testimonials/sara-amiri.webp']);
    }

    public function down(): void
    {
        // One-way data repair: the previous values referenced deleted uploads.
    }
};
