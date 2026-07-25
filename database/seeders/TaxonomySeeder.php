<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Industry;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

/**
 * Industries (project tags) and post categories (blog filter chips).
 * Categories mirror the Figma "Filters" component 1363:7500.
 */
final class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            [
                'en' => ['name' => 'Food & Beverage', 'slug' => 'food-beverage'],
                'fa' => ['name' => 'غذا و نوشیدنی', 'slug' => 'غذا-و-نوشیدنی'],
                'ar' => ['name' => 'الأغذية والمشروبات', 'slug' => 'الأغذية-والمشروبات'],
            ],
            [
                'en' => ['name' => 'Automotive', 'slug' => 'automotive'],
                'fa' => ['name' => 'خودرو', 'slug' => 'خودرو'],
                'ar' => ['name' => 'السيارات', 'slug' => 'السيارات'],
            ],
            [
                'en' => ['name' => 'Healthcare', 'slug' => 'healthcare'],
                'fa' => ['name' => 'سلامت', 'slug' => 'سلامت'],
                'ar' => ['name' => 'الرعاية الصحية', 'slug' => 'الرعاية-الصحية'],
            ],
            [
                'en' => ['name' => 'Travel', 'slug' => 'travel'],
                'fa' => ['name' => 'گردشگری', 'slug' => 'گردشگری'],
                'ar' => ['name' => 'السفر', 'slug' => 'السفر'],
            ],
            [
                'en' => ['name' => 'Beauty & Wellness', 'slug' => 'beauty-wellness'],
                'fa' => ['name' => 'زیبایی و سلامت', 'slug' => 'زیبایی-و-سلامت'],
                'ar' => ['name' => 'الجمال والعافية', 'slug' => 'الجمال-والعافية'],
            ],
        ];

        foreach ($industries as $index => $translations) {
            $industry = Industry::updateOrCreate(
                ['id' => $index + 1],
                ['sort_order' => $index],
            );

            $industry->setTranslations($translations);
        }

        // Blog categories — Figma filter chips 1363:7500
        $categories = [
            [
                'en' => ['name' => 'Branding', 'slug' => 'branding'],
                'fa' => ['name' => 'برندینگ', 'slug' => 'برندینگ'],
                'ar' => ['name' => 'الهوية', 'slug' => 'الهوية'],
            ],
            [
                'en' => ['name' => 'Marketing Design', 'slug' => 'marketing-design'],
                'fa' => ['name' => 'طراحی بازاریابی', 'slug' => 'طراحی-بازاریابی'],
                'ar' => ['name' => 'تصميم التسويق', 'slug' => 'تصميم-التسويق'],
            ],
            [
                'en' => ['name' => 'Content Production', 'slug' => 'content-production'],
                'fa' => ['name' => 'تولید محتوا', 'slug' => 'تولید-محتوا'],
                'ar' => ['name' => 'إنتاج المحتوى', 'slug' => 'إنتاج-المحتوى'],
            ],
            [
                'en' => ['name' => 'Social Media Support', 'slug' => 'social-media-support'],
                'fa' => ['name' => 'پشتیبانی شبکه‌های اجتماعی', 'slug' => 'پشتیبانی-شبکه‌های-اجتماعی'],
                'ar' => ['name' => 'دعم وسائل التواصل', 'slug' => 'دعم-وسائل-التواصل'],
            ],
        ];

        foreach ($categories as $index => $translations) {
            $category = PostCategory::updateOrCreate(
                ['id' => $index + 1],
                ['sort_order' => $index],
            );

            $category->setTranslations($translations);
        }
    }
}
