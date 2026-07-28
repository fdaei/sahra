<?php

declare(strict_types=1);

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Match the English Home projects subtitle exactly to Figma 1419:9221.
 */
return new class extends Migration
{
    public function up(): void
    {
        $pageId = DB::table('pages')->where('key', 'home')->value('id');

        if ($pageId === null) {
            return;
        }

        $sectionId = DB::table('page_sections')
            ->where('sectionable_type', Page::class)
            ->where('sectionable_id', $pageId)
            ->where('type', 'projects_showcase')
            ->value('id');

        if ($sectionId === null) {
            return;
        }

        DB::table('page_section_translations')
            ->where('page_section_id', $sectionId)
            ->where('locale', 'en')
            ->update([
                'subtitle' => 'A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Content migrations are intentionally irreversible because editors may
        // update this field in Filament after deployment.
    }
};
