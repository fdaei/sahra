<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MenuLocation;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Support\NavigationBuilder;
use App\Support\SiteSettings;
use Illuminate\Database\Seeder;

/**
 * Site settings, social links and navigation.
 *
 * Copy is taken from the Figma frames:
 *   footer            1419:9317
 *   contact details   1363:8934
 *   header            1419:9339
 *
 * Persian and Arabic strings are working translations of the English source —
 * they should be reviewed by a native copywriter before launch (noted in
 * docs/IMPLEMENTATION-LOG.md).
 */
final class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->socialLinks();
        $this->headerMenu();
        $this->footerMenu();

        SiteSettings::flush();
        NavigationBuilder::flush();
    }

    private function settings(): void
    {
        $values = [
            'site_name' => [
                'translatable' => true,
                'value' => ['en' => 'Sahra', 'fa' => 'صحرا', 'ar' => 'صحراء'],
            ],
            'tagline' => [
                'translatable' => true,
                'value' => [
                    'en' => 'See the Horizon',
                    'fa' => 'افق را ببین',
                    'ar' => 'انظر إلى الأفق',
                ],
            ],
            'footer_description' => [
                'translatable' => true,
                'value' => [
                    'en' => 'We help brands move from scattered content to structured direction.',
                    'fa' => 'ما به برندها کمک می‌کنیم از محتوای پراکنده به مسیری ساختارمند برسند.',
                    'ar' => 'نساعد العلامات التجارية على الانتقال من المحتوى المبعثر إلى اتجاه منظم.',
                ],
            ],
            'contact_whatsapp' => ['translatable' => false, 'value' => '+96 7781 1213'],
            'contact_phone' => ['translatable' => false, 'value' => '+96 7781 1213'],
            'contact_email' => ['translatable' => false, 'value' => 'Sahramarketing@gmail.com'],
            'contact_location' => [
                'translatable' => true,
                'value' => ['en' => 'Muscat, Oman', 'fa' => 'مسقط، عمان', 'ar' => 'مسقط، عُمان'],
            ],
            'contact_working_with' => [
                'translatable' => true,
                'value' => [
                    'en' => 'Brands in Oman and Beyond',
                    'fa' => 'برندهایی در عمان و فراتر از آن',
                    'ar' => 'علامات تجارية في عُمان وخارجها',
                ],
            ],
            'seo_default_title' => [
                'translatable' => true,
                'value' => [
                    'en' => 'Sahra — Digital Marketing Agency in Muscat',
                    'fa' => 'صحرا — آژانس بازاریابی دیجیتال در مسقط',
                    'ar' => 'صحراء — وكالة تسويق رقمي في مسقط',
                ],
            ],
            'seo_default_description' => [
                'translatable' => true,
                'value' => [
                    'en' => 'Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.',
                    'fa' => 'صحرا به کسب‌وکارها در عمان کمک می‌کند تا از طریق استراتژی، محتوا، برندینگ و بازاریابی دیجیتال حضور برند قوی‌تری بسازند.',
                    'ar' => 'تساعد صحراء الشركات في عُمان على بناء حضور أقوى لعلامتها التجارية من خلال الاستراتيجية والمحتوى والهوية والتسويق الرقمي.',
                ],
            ],
            'seo_default_image' => ['translatable' => false, 'value' => null],
            'seo_organization_name' => [
                'translatable' => true,
                'value' => ['en' => 'Sahra', 'fa' => 'صحرا', 'ar' => 'صحراء'],
            ],
        ];

        foreach ($values as $key => $config) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => str_starts_with($key, 'seo_') ? 'seo' : 'general',
                    'value' => $config['translatable']
                        ? $config['value']
                        : ['value' => $config['value']],
                    'is_translatable' => $config['translatable'],
                ],
            );
        }
    }

    private function socialLinks(): void
    {
        $links = [
            ['instagram', 'Instagram', 'https://instagram.com/sahramarketing', 'instagram', 1],
            ['linkedin', 'LinkedIn', 'https://linkedin.com/company/sahramarketing', 'linkedin', 2],
            ['whatsapp', 'WhatsApp', 'https://wa.me/96777811213', 'message-circle', 3],
            ['x', 'X', 'https://x.com/sahramarketing', 'twitter', 4],
            ['youtube', 'YouTube', 'https://youtube.com/@sahramarketing', 'youtube', 5],
        ];

        foreach ($links as [$platform, $label, $url, $icon, $order]) {
            SocialLink::updateOrCreate(
                ['platform' => $platform],
                [
                    'label' => $label,
                    'url' => $url,
                    'icon' => $icon,
                    'sort_order' => $order,
                    'is_active' => true,
                ],
            );
        }
    }

    /**
     * Header — Figma 1419:9339.
     * Home / Work / Service / Insight / About, plus the Let's Talk CTA.
     */
    private function headerMenu(): void
    {
        $menu = Menu::updateOrCreate(
            ['location' => MenuLocation::Header],
            ['name' => 'Header navigation'],
        );

        $menu->items()->delete();

        $items = [
            ['home', ['en' => 'Home', 'fa' => 'خانه', 'ar' => 'الرئيسية'], false],
            ['work.index', ['en' => 'Work', 'fa' => 'نمونه‌کارها', 'ar' => 'أعمالنا'], false],
            ['services', ['en' => 'Service', 'fa' => 'خدمات', 'ar' => 'الخدمات'], false],
            ['insights.index', ['en' => 'Insight', 'fa' => 'بینش', 'ar' => 'رؤى'], false],
            ['about', ['en' => 'About', 'fa' => 'درباره ما', 'ar' => 'من نحن'], false],
            ['contact', ['en' => "Let's Talk", 'fa' => 'گفتگو کنیم', 'ar' => 'لنتحدث'], true],
        ];

        foreach ($items as $index => [$route, $labels, $isCta]) {
            $item = $menu->items()->create([
                'route_name' => $route,
                'target' => '_self',
                'is_cta' => $isCta,
                'sort_order' => $index,
                'is_active' => true,
            ]);

            $item->setTranslations(
                collect($labels)
                    ->map(fn (string $label): array => ['label' => $label])
                    ->all(),
            );
        }
    }

    /**
     * Footer — Figma 1419:9317.
     * Three columns: Quick Links, Social Links, Info (Info is rendered from
     * settings, so only the first two are menu-driven).
     */
    private function footerMenu(): void
    {
        $menu = Menu::updateOrCreate(
            ['location' => MenuLocation::Footer],
            ['name' => 'Footer navigation'],
        );

        $menu->items()->delete();

        $columns = [
            [
                'labels' => ['en' => 'Quick Links', 'fa' => 'دسترسی سریع', 'ar' => 'روابط سريعة'],
                'children' => [
                    ['home', ['en' => 'Home', 'fa' => 'خانه', 'ar' => 'الرئيسية']],
                    ['services', ['en' => 'Services', 'fa' => 'خدمات', 'ar' => 'الخدمات']],
                    ['work.index', ['en' => 'Work', 'fa' => 'نمونه‌کارها', 'ar' => 'أعمالنا']],
                    ['insights.index', ['en' => 'Insight', 'fa' => 'بینش', 'ar' => 'رؤى']],
                    ['about', ['en' => 'About', 'fa' => 'درباره ما', 'ar' => 'من نحن']],
                    ['contact', ['en' => 'Contact', 'fa' => 'تماس', 'ar' => 'اتصل بنا']],
                ],
            ],
            [
                'labels' => ['en' => 'Social Links', 'fa' => 'شبکه‌های اجتماعی', 'ar' => 'وسائل التواصل'],
                'children' => [],
                'social' => true,
            ],
        ];

        foreach ($columns as $columnIndex => $column) {
            $heading = $menu->items()->create([
                'sort_order' => $columnIndex,
                'is_active' => true,
            ]);

            $heading->setTranslations(
                collect($column['labels'])
                    ->map(fn (string $label): array => ['label' => $label])
                    ->all(),
            );

            // Social column links out to the SocialLink records.
            if ($column['social'] ?? false) {
                SocialLink::query()
                    ->orderBy('sort_order')
                    ->get()
                    ->each(function (SocialLink $link, int $index) use ($menu, $heading): void {
                        $child = $menu->items()->create([
                            'parent_id' => $heading->id,
                            'url' => $link->url,
                            'target' => '_blank',
                            'sort_order' => $index,
                            'is_active' => true,
                        ]);

                        $child->setTranslations([
                            'en' => ['label' => $link->label],
                            'fa' => ['label' => $link->label],
                            'ar' => ['label' => $link->label],
                        ]);
                    });

                continue;
            }

            foreach ($column['children'] as $index => [$route, $labels]) {
                $child = $menu->items()->create([
                    'parent_id' => $heading->id,
                    'route_name' => $route,
                    'target' => '_self',
                    'sort_order' => $index,
                    'is_active' => true,
                ]);

                $child->setTranslations(
                    collect($labels)
                        ->map(fn (string $label): array => ['label' => $label])
                        ->all(),
                );
            }
        }
    }
}
