<?php

declare(strict_types=1);

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Publish the packages section for databases created before the Figma section
 * was implemented. Existing editor-created package cards are never replaced.
 */
return new class extends Migration
{
    public function up(): void
    {
        $pageId = DB::table('pages')->where('key', 'home')->value('id');

        if ($pageId === null) {
            return;
        }

        DB::transaction(function () use ($pageId): void {
            $now = now();
            $sectionId = DB::table('page_sections')
                ->where('sectionable_type', Page::class)
                ->where('sectionable_id', $pageId)
                ->where('type', 'packages')
                ->value('id');

            if ($sectionId === null) {
                $sectionId = DB::table('page_sections')->insertGetId([
                    'sectionable_type' => Page::class,
                    'sectionable_id' => $pageId,
                    'type' => 'packages',
                    'sort_order' => 7,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('page_sections')
                    ->where('id', $sectionId)
                    ->update([
                        'is_visible' => true,
                        'updated_at' => $now,
                    ]);
            }

            $sectionTranslations = [
                'en' => [
                    'eyebrow' => 'Our Packages',
                    'title' => 'Packages Built for Brand Growth',
                    'subtitle' => 'Three focused packages designed for different business needs, growth stages, and levels of support.',
                    'content' => 'Need help choosing the right package?',
                    'description' => 'Let’s talk about your goals and find the best solution for your brand.',
                    'primary_cta_label' => 'Contact Us',
                    'primary_cta_url' => '/contact',
                ],
                'fa' => [
                    'eyebrow' => 'پکیج‌های ما',
                    'title' => 'پکیج‌هایی برای رشد برند',
                    'subtitle' => 'سه پکیج هدفمند برای نیازها، مراحل رشد و سطوح پشتیبانی متفاوت.',
                    'content' => 'برای انتخاب پکیج مناسب کمک می‌خواهید؟',
                    'description' => 'درباره اهدافتان صحبت کنیم و بهترین راهکار را برای برند شما پیدا کنیم.',
                    'primary_cta_label' => 'تماس با ما',
                    'primary_cta_url' => '/contact',
                ],
                'ar' => [
                    'eyebrow' => 'باقاتنا',
                    'title' => 'باقات مصممة لنمو العلامة',
                    'subtitle' => 'ثلاث باقات مركزة لاحتياجات ومراحل نمو ومستويات دعم مختلفة.',
                    'content' => 'هل تحتاج مساعدة في اختيار الباقة المناسبة؟',
                    'description' => 'لنتحدث عن أهدافك ونجد أفضل حل لعلامتك.',
                    'primary_cta_label' => 'تواصل معنا',
                    'primary_cta_url' => '/contact',
                ],
            ];

            foreach ($sectionTranslations as $locale => $translation) {
                DB::table('page_section_translations')->updateOrInsert(
                    [
                        'page_section_id' => $sectionId,
                        'locale' => $locale,
                    ],
                    $translation + [
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                );
            }

            if (DB::table('section_items')->where('page_section_id', $sectionId)->exists()) {
                return;
            }

            foreach ($this->packages() as $sortOrder => $translations) {
                $itemId = DB::table('section_items')->insertGetId([
                    'page_section_id' => $sectionId,
                    'sort_order' => $sortOrder,
                    'is_visible' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($translations as $locale => $translation) {
                    $translation['features'] = json_encode(
                        $translation['features'],
                        JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE,
                    );

                    DB::table('section_item_translations')->insert(
                        $translation + [
                            'section_item_id' => $itemId,
                            'locale' => $locale,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    );
                }
            }
        });
    }

    public function down(): void
    {
        // Intentionally irreversible: package content may have been edited in
        // Filament after this migration and must not be deleted on rollback.
    }

    /**
     * @return array<int, array<string, array<string, mixed>>>
     */
    private function packages(): array
    {
        return [
            [
                'en' => [
                    'title' => 'Sahra Essential', 'label' => 'Starts From', 'value' => '199',
                    'suffix' => 'OMR / 1 Month', 'description' => 'A clear foundation for your brand presence',
                    'features' => ['Content Planning', 'Visual Direction', 'Social Media Support', 'Monthly Execution'],
                    'footer' => 'Best for small businesses',
                ],
                'fa' => [
                    'title' => 'صحرا اسنشال', 'label' => 'شروع از', 'value' => '۱۹۹',
                    'suffix' => 'ریال عمان / ۱ ماه', 'description' => 'پایه‌ای شفاف برای حضور برند شما',
                    'features' => ['برنامه‌ریزی محتوا', 'جهت‌گیری بصری', 'پشتیبانی شبکه‌های اجتماعی', 'اجرای ماهانه'],
                    'footer' => 'مناسب کسب‌وکارهای کوچک',
                ],
                'ar' => [
                    'title' => 'صحراء الأساسية', 'label' => 'تبدأ من', 'value' => '199',
                    'suffix' => 'ر.ع / شهر واحد', 'description' => 'أساس واضح لحضور علامتك',
                    'features' => ['تخطيط المحتوى', 'التوجيه البصري', 'دعم وسائل التواصل', 'التنفيذ الشهري'],
                    'footer' => 'الأفضل للشركات الصغيرة',
                ],
            ],
            [
                'en' => [
                    'title' => 'Sahra Growth', 'label' => 'Starts From', 'value' => '499',
                    'suffix' => 'OMR / 1 Month', 'description' => 'A structured approach to build and grow your presence',
                    'badge' => 'Most Popular',
                    'features' => ['Content Strategy', 'Brand-Aligned Content', 'Campaign Support', 'Performance Optimization'],
                    'footer' => 'Best for growing brands',
                ],
                'fa' => [
                    'title' => 'صحرا گروث', 'label' => 'شروع از', 'value' => '۴۹۹',
                    'suffix' => 'ریال عمان / ۱ ماه', 'description' => 'رویکردی ساختاریافته برای ساخت و رشد حضور برند',
                    'badge' => 'محبوب‌ترین',
                    'features' => ['استراتژی محتوا', 'محتوای هم‌راستا با برند', 'پشتیبانی کمپین', 'بهینه‌سازی عملکرد'],
                    'footer' => 'مناسب برندهای در حال رشد',
                ],
                'ar' => [
                    'title' => 'صحراء للنمو', 'label' => 'تبدأ من', 'value' => '499',
                    'suffix' => 'ر.ع / شهر واحد', 'description' => 'نهج منظم لبناء حضورك وتنميته',
                    'badge' => 'الأكثر شعبية',
                    'features' => ['استراتيجية المحتوى', 'محتوى متوافق مع العلامة', 'دعم الحملات', 'تحسين الأداء'],
                    'footer' => 'الأفضل للعلامات النامية',
                ],
            ],
            [
                'en' => [
                    'title' => 'Sahra Horizon', 'label' => 'Starts From', 'value' => '749',
                    'suffix' => 'OMR / 1 Month', 'description' => 'A complete partnership for brand growth',
                    'features' => ['Full Marketing Strategy', 'Brand Development', 'Campaign Planning', 'Continuous Optimization'],
                    'footer' => 'Best for scaling brands',
                ],
                'fa' => [
                    'title' => 'صحرا هورایزن', 'label' => 'شروع از', 'value' => '۷۴۹',
                    'suffix' => 'ریال عمان / ۱ ماه', 'description' => 'همکاری کامل برای رشد برند',
                    'features' => ['استراتژی کامل بازاریابی', 'توسعه برند', 'برنامه‌ریزی کمپین', 'بهینه‌سازی مستمر'],
                    'footer' => 'مناسب برندهای مقیاس‌پذیر',
                ],
                'ar' => [
                    'title' => 'صحراء الأفق', 'label' => 'تبدأ من', 'value' => '749',
                    'suffix' => 'ر.ع / شهر واحد', 'description' => 'شراكة متكاملة لنمو العلامة',
                    'features' => ['استراتيجية تسويق كاملة', 'تطوير العلامة', 'تخطيط الحملات', 'تحسين مستمر'],
                    'footer' => 'الأفضل للعلامات المتوسعة',
                ],
            ],
        ];
    }
};
