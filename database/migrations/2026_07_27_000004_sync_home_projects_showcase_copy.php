<?php

declare(strict_types=1);

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Add the Figma 1419:9216 intro copy to existing Home installations.
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

        $subtitles = [
            'en' => 'A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction',
            'fa' => 'مجموعه‌ای از پروژه‌های برند، محتوا و طراحی بازاریابی برای کمک به کسب‌وکارها تا شفاف‌تر ارتباط برقرار کنند و هدفمند رشد کنند.',
            'ar' => 'مجموعة من مشاريع العلامة والمحتوى والتصميم التسويقي لمساعدة الشركات على التواصل بوضوح والنمو باتجاه هادف.',
        ];

        foreach ($subtitles as $locale => $subtitle) {
            DB::table('page_section_translations')
                ->where('page_section_id', $sectionId)
                ->where('locale', $locale)
                ->update([
                    'subtitle' => $subtitle,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        // Content migrations are intentionally irreversible because editors may
        // update this field in Filament after deployment.
    }
};
