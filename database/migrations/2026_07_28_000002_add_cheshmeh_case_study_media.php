<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Case-study media for the one project the design expands in full.
 *
 * Figma 639:1617 (single project, LTR):
 *   banner            646:1754            1248×624, radius 16
 *   content showcase  820:2101 / 820:2103 / 822:2106
 *   before / after    1361:7100 / 1361:7097
 *
 * The images were rendered from those nodes, so the crops match the frame.
 */
return new class extends Migration
{
    /** @var array<int, string> */
    private const SHOWCASE = [
        'projects/cheshmeh-showcase-1.webp',
        'projects/cheshmeh-showcase-2.webp',
        'projects/cheshmeh-showcase-3.webp',
    ];

    public function up(): void
    {
        $id = DB::table('project_translations')
            ->where('locale', 'en')
            ->where('slug', 'cheshmeh-beauty')
            ->value('project_id');

        if ($id === null) {
            return;
        }

        DB::table('projects')->where('id', $id)->update([
            'banner_path' => 'projects/cheshmeh-banner.webp',
            'before_image_path' => 'projects/cheshmeh-before.webp',
            'after_image_path' => 'projects/cheshmeh-after.webp',
        ]);

        DB::table('project_images')->where('project_id', $id)->delete();

        foreach (self::SHOWCASE as $order => $path) {
            DB::table('project_images')->insert([
                'project_id' => $id,
                'path' => $path,
                'sort_order' => $order,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $id = DB::table('project_translations')
            ->where('locale', 'en')
            ->where('slug', 'cheshmeh-beauty')
            ->value('project_id');

        if ($id === null) {
            return;
        }

        DB::table('project_images')->where('project_id', $id)->delete();

        DB::table('projects')->where('id', $id)->update([
            'banner_path' => null,
            'before_image_path' => null,
            'after_image_path' => null,
        ]);
    }
};
