<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PublicationStatus;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * The four services. Copy from Figma 1323:7189.
 * Image paths point at the manifest destinations (docs/ASSET-MANIFEST.md §5).
 */
final class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'image' => 'services/branding.webp',
                'icon' => 'palette',
                'en' => [
                    'title' => 'Branding',
                    'slug' => 'branding',
                    'description' => 'Building a clear identity that helps your brand become recognizable, consistent, and memorable across every touchpoint.',
                    'features' => ['Logo design', 'Visual Identity Development', 'Brand book creation', 'Brand consistency systems', 'Posters'],
                    'image_alt' => 'Framed poster reading "Where identity becomes direction"',
                ],
                'fa' => [
                    'title' => 'برندینگ',
                    'slug' => 'برندینگ',
                    'description' => 'ساخت هویتی شفاف که برند شما را در هر نقطه تماس قابل تشخیص، یکدست و ماندگار می‌کند.',
                    'features' => ['طراحی لوگو', 'توسعه هویت بصری', 'تدوین کتاب برند', 'سیستم‌های یکپارچگی برند', 'پوستر'],
                    'image_alt' => 'پوستر قاب‌شده با عبارت «جایی که هویت به جهت تبدیل می‌شود»',
                ],
                'ar' => [
                    'title' => 'الهوية التجارية',
                    'slug' => 'الهوية-التجارية',
                    'description' => 'بناء هوية واضحة تجعل علامتك مميزة ومتسقة ولا تُنسى في كل نقطة تواصل.',
                    'features' => ['تصميم الشعار', 'تطوير الهوية البصرية', 'إعداد دليل العلامة', 'أنظمة اتساق العلامة', 'الملصقات'],
                    'image_alt' => 'ملصق مؤطر يحمل عبارة «حيث تصبح الهوية اتجاهاً»',
                ],
            ],
            [
                'image' => 'services/content-production.webp',
                'icon' => 'video',
                'en' => [
                    'title' => 'Content Production',
                    'slug' => 'content-production',
                    'description' => 'Creating meaningful content that connects your brand with the right audience.',
                    'features' => ['Social media content creation', 'Post and story design', 'Reels and short-form content support', 'Campaign visuals', 'Content direction and creative planning'],
                    'image_alt' => 'Warm desk setup with laptop, notebook and coffee',
                ],
                'fa' => [
                    'title' => 'تولید محتوا',
                    'slug' => 'تولید-محتوا',
                    'description' => 'ساخت محتوای معنادار که برند شما را به مخاطب درست وصل می‌کند.',
                    'features' => ['تولید محتوای شبکه‌های اجتماعی', 'طراحی پست و استوری', 'پشتیبانی ریلز و محتوای کوتاه', 'بصری‌های کمپین', 'جهت‌گیری محتوا و برنامه‌ریزی خلاق'],
                    'image_alt' => 'میز کار گرم با لپ‌تاپ، دفترچه و قهوه',
                ],
                'ar' => [
                    'title' => 'إنتاج المحتوى',
                    'slug' => 'إنتاج-المحتوى',
                    'description' => 'إنشاء محتوى هادف يربط علامتك بالجمهور المناسب.',
                    'features' => ['إنشاء محتوى وسائل التواصل', 'تصميم المنشورات والقصص', 'دعم الريلز والمحتوى القصير', 'مرئيات الحملات', 'توجيه المحتوى والتخطيط الإبداعي'],
                    'image_alt' => 'مكتب دافئ مع حاسوب محمول ودفتر وقهوة',
                ],
            ],
            [
                'image' => 'services/marketing-design.webp',
                'icon' => 'megaphone',
                'en' => [
                    'title' => 'Marketing Design',
                    'slug' => 'marketing-design',
                    'description' => 'Creating visual assets that communicate your message with clarity and impact.',
                    'features' => ['Promotional creative', 'Campaign assets', 'Advertising visuals', 'Presentation and communication materials'],
                    'image_alt' => 'Large "MARKETING" wall type behind a seated person',
                ],
                'fa' => [
                    'title' => 'طراحی بازاریابی',
                    'slug' => 'طراحی-بازاریابی',
                    'description' => 'ساخت دارایی‌های بصری که پیام شما را شفاف و اثرگذار منتقل می‌کند.',
                    'features' => ['خلاقیت تبلیغاتی', 'دارایی‌های کمپین', 'بصری‌های تبلیغاتی', 'مواد ارائه و ارتباطات'],
                    'image_alt' => 'تایپوگرافی بزرگ «MARKETING» روی دیوار پشت فردی نشسته',
                ],
                'ar' => [
                    'title' => 'تصميم التسويق',
                    'slug' => 'تصميم-التسويق',
                    'description' => 'إنشاء أصول بصرية توصل رسالتك بوضوح وتأثير.',
                    'features' => ['الإبداع الترويجي', 'أصول الحملات', 'المرئيات الإعلانية', 'مواد العرض والتواصل'],
                    'image_alt' => 'كلمة «MARKETING» كبيرة على الجدار خلف شخص جالس',
                ],
            ],
            [
                'image' => 'services/social-media-support.webp',
                'icon' => 'share-2',
                'en' => [
                    'title' => 'Social Media Support',
                    'slug' => 'social-media-support',
                    'description' => 'Building a consistent social presence through structured content and ongoing support.',
                    'features' => ['Page management', 'Content structuring', 'Visual consistency across platforms', 'Ongoing creative support for digital presence'],
                    'image_alt' => 'Hand holding a phone showing analytics',
                ],
                'fa' => [
                    'title' => 'پشتیبانی شبکه‌های اجتماعی',
                    'slug' => 'پشتیبانی-شبکه‌های-اجتماعی',
                    'description' => 'ساخت حضور اجتماعی یکدست از طریق محتوای ساختارمند و پشتیبانی مستمر.',
                    'features' => ['مدیریت صفحه', 'ساختاردهی محتوا', 'یکپارچگی بصری در پلتفرم‌ها', 'پشتیبانی خلاق مستمر برای حضور دیجیتال'],
                    'image_alt' => 'دستی که گوشی با نمودار تحلیل را نگه داشته',
                ],
                'ar' => [
                    'title' => 'دعم وسائل التواصل',
                    'slug' => 'دعم-وسائل-التواصل',
                    'description' => 'بناء حضور اجتماعي متسق عبر محتوى منظم ودعم مستمر.',
                    'features' => ['إدارة الصفحات', 'هيكلة المحتوى', 'الاتساق البصري عبر المنصات', 'دعم إبداعي مستمر للحضور الرقمي'],
                    'image_alt' => 'يد تحمل هاتفاً يعرض التحليلات',
                ],
            ],
        ];

        foreach ($services as $index => $data) {
            $service = Service::updateOrCreate(
                ['id' => $index + 1],
                [
                    'status' => PublicationStatus::Published,
                    'published_at' => now(),
                    'sort_order' => $index,
                    'show_on_home' => $index === 0,
                    'show_on_services_page' => true,
                    'home_orbit_group' => $index === 0 ? 'active' : null,
                    'external_url' => $index === 0
                        ? 'https://www.ramotion.com/branding/'
                        : null,
                    'icon' => $data['icon'],
                    'image_path' => $data['image'],
                ],
            );

            $service->setTranslations([
                'en' => $data['en'],
                'fa' => $data['fa'],
                'ar' => $data['ar'],
            ]);
        }

        $orbitItems = [
            ['design-systems', 'Design systems', 'active', 'https://www.ramotion.com/design-systems/', 'projects/kerman-motors.webp'],
            ['app-design', 'App design', 'active', 'https://www.ramotion.com/app-design/', 'projects/cheshmeh.webp'],
            ['brand-strategy', 'Brand strategy', 'active', 'https://www.ramotion.com/brand-strategy/', 'posts/brand-direction.webp'],
            ['ui-ux-design', 'UI/UX design', 'active', 'https://www.ramotion.com/ui-ux-design/', 'projects/fakhar-clinic.webp'],
            ['web-design', 'Web design', 'active', 'https://www.ramotion.com/web-design/', 'projects/baghche.webp'],
            ['web-app-development', 'Web App development', 'active', 'https://www.ramotion.com/web-app-development/', 'projects/plus-protein.webp'],
            ['printing-services', 'Printing services', 'brand', null, null],
            ['packaging-design', 'Packaging design', 'brand', null, null],
            ['pr-campaigns', 'PR Campaigns', 'brand', null, null],
            ['video-productions', 'Video productions', 'brand', null, null],
            ['data-science', 'Data science', 'product', null, null],
            ['production-planning', 'Production planning', 'product', null, null],
            ['gtm-strategy', 'GTM strategy', 'product', null, null],
            ['smm', 'SMM', 'product', null, null],
            ['product-writing', 'Product writing', 'product', null, null],
        ];

        foreach ($orbitItems as $index => [$slug, $title, $group, $url, $image]) {
            $service = Service::withTrashed()
                ->whereHas(
                    'translations',
                    fn ($query) => $query
                        ->where('locale', config('locales.fallback'))
                        ->where('slug', $slug),
                )
                ->first();

            if ($service === null) {
                $service = Service::create([
                    'status' => PublicationStatus::Published,
                    'published_at' => now(),
                    'sort_order' => $index + 1,
                    'show_on_home' => true,
                    'show_on_services_page' => false,
                    'home_orbit_group' => $group,
                    'external_url' => $url,
                    'image_path' => $image,
                ]);
            } else {
                if ($service->trashed()) {
                    $service->restore();
                }

                $service->update([
                    'status' => PublicationStatus::Published,
                    'published_at' => now(),
                    'sort_order' => $index + 1,
                    'show_on_home' => true,
                    'show_on_services_page' => false,
                    'home_orbit_group' => $group,
                    'external_url' => $url,
                    'image_path' => $image,
                ]);
            }

            $translations = [];
            foreach (array_keys(config('locales.supported')) as $locale) {
                $translations[$locale] = [
                    'title' => $title,
                    'slug' => $slug,
                    'description' => null,
                    'features' => [],
                    'image_alt' => $image === null ? null : $title,
                ];
            }

            $service->setTranslations($translations);
        }
    }
}
