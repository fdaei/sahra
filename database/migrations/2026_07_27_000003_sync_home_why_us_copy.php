<?php

declare(strict_types=1);

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Sync the existing Home "Why us" heading and subtitle with Figma 1419:9230.
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
            ->where('type', 'why_us')
            ->value('id');

        if ($sectionId === null) {
            return;
        }

        $translations = [
            'en' => [
                'eyebrow' => 'Why us',
                'title' => 'Why brands choose Sahra',
                'subtitle' => 'Because every creative decision is built around brand clarity, consistency, and growth.',
            ],
            'fa' => [
                'eyebrow' => 'چرا ما',
                'title' => 'چرا برندها صحرا را انتخاب می‌کنند',
                'subtitle' => 'زیرا هر تصمیم خلاقانه بر پایه شفافیت برند، انسجام و رشد شکل می‌گیرد.',
            ],
            'ar' => [
                'eyebrow' => 'لماذا نحن',
                'title' => 'لماذا تختار العلامات التجارية صحرا',
                'subtitle' => 'لأن كل قرار إبداعي يُبنى حول وضوح العلامة واتساقها ونموها.',
            ],
        ];

        foreach ($translations as $locale => $content) {
            DB::table('page_section_translations')
                ->where('page_section_id', $sectionId)
                ->where('locale', $locale)
                ->update($content + ['updated_at' => now()]);
        }
    }

    public function down(): void
    {
        // Content migrations are intentionally irreversible because editors may
        // update these fields in Filament after deployment.
    }
};
