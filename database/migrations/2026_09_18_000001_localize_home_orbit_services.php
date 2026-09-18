<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $titles = [
            'design-systems' => ['Design systems', 'سیستم‌های طراحی', 'أنظمة التصميم'],
            'app-design' => ['App design', 'طراحی اپلیکیشن', 'تصميم التطبيقات'],
            'brand-strategy' => ['Brand strategy', 'استراتژی برند', 'استراتيجية العلامة التجارية'],
            'ui-ux-design' => ['UI/UX design', 'طراحی رابط و تجربهٔ کاربری', 'تصميم الواجهة وتجربة المستخدم'],
            'web-design' => ['Web design', 'طراحی وب‌سایت', 'تصميم المواقع'],
            'web-app-development' => ['Web App development', 'توسعهٔ اپلیکیشن تحت وب', 'تطوير تطبيقات الويب'],
            'printing-services' => ['Printing services', 'خدمات چاپ', 'خدمات الطباعة'],
            'packaging-design' => ['Packaging design', 'طراحی بسته‌بندی', 'تصميم التغليف'],
            'pr-campaigns' => ['PR Campaigns', 'کمپین‌های روابط عمومی', 'حملات العلاقات العامة'],
            'video-productions' => ['Video productions', 'تولید ویدئو', 'إنتاج الفيديو'],
            'data-science' => ['Data science', 'علم داده', 'علوم البيانات'],
            'production-planning' => ['Production planning', 'برنامه‌ریزی تولید', 'تخطيط الإنتاج'],
            'gtm-strategy' => ['GTM strategy', 'استراتژی ورود به بازار', 'استراتيجية دخول السوق'],
            'smm' => ['SMM', 'بازاریابی شبکه‌های اجتماعی', 'التسويق عبر وسائل التواصل'],
            'product-writing' => ['Product writing', 'محتوانویسی محصول', 'كتابة محتوى المنتجات'],
        ];

        foreach ($titles as $slug => [$english, $persian, $arabic]) {
            $serviceId = DB::table('service_translations')
                ->where('locale', 'en')
                ->where('slug', $slug)
                ->value('service_id');

            if ($serviceId === null) {
                continue;
            }

            foreach (['fa' => $persian, 'ar' => $arabic] as $locale => $title) {
                DB::table('service_translations')
                    ->where('service_id', $serviceId)
                    ->where('locale', $locale)
                    ->where('title', $english)
                    ->update(['title' => $title, 'updated_at' => now()]);

                DB::table('service_translations')
                    ->where('service_id', $serviceId)
                    ->where('locale', $locale)
                    ->where('image_alt', $english)
                    ->update(['image_alt' => $title, 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        // Keep translated and editor-customized titles when rolling back.
    }
};
