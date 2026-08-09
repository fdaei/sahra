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
    /**
     * Per-locale social labels, keyed by platform — populated by socialLinks()
     * and consumed by footerMenu(). The SocialLink table itself holds one
     * `label` column, so the translated forms have to reach the menu item
     * translations directly.
     *
     * @var array<string, array<string, string>>
     */
    private array $socialLabels = [];

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
                'value' => ['en' => 'Sahra', 'fa' => 'صحرا', 'ar' => 'صحرا'],
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
                    'ar' => 'صحرا — وكالة تسويق رقمي في مسقط',
                ],
            ],
            'seo_default_description' => [
                'translatable' => true,
                'value' => [
                    'en' => 'Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.',
                    'fa' => 'صحرا به کسب‌وکارها در عمان کمک می‌کند تا از طریق استراتژی، محتوا، برندینگ و بازاریابی دیجیتال حضور برند قوی‌تری بسازند.',
                    'ar' => 'تساعد صحرا الشركات في عُمان على بناء حضور أقوى لعلامتها التجارية من خلال الاستراتيجية والمحتوى والهوية والتسويق الرقمي.',
                ],
            ],
            'seo_default_image' => ['translatable' => false, 'value' => null],
            'seo_organization_name' => [
                'translatable' => true,
                'value' => ['en' => 'Sahra', 'fa' => 'صحرا', 'ar' => 'صحرا'],
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
        // Order and membership are the footer frames' own: Instagram, LinkedIn,
        // YouTube, WhatsApp (en 1419:9317 / ar 1365:10075). Neither lists X —
        // it was invented here, so it is dropped rather than left inactive, or
        // the footer column keeps rendering it (that query has no is_active
        // filter). Labels carry their own per-locale spelling: the frames
        // transliterate them, they are not left in Latin script.
        $links = [
            ['instagram', ['en' => 'Instagram', 'fa' => 'اینستاگرام', 'ar' => 'إنستغرام'], 'https://instagram.com/sahramarketing', 'instagram', 1],
            ['linkedin', ['en' => 'LinkedIn', 'fa' => 'لینکدین', 'ar' => 'لينكدإن'], 'https://linkedin.com/company/sahramarketing', 'linkedin', 2],
            ['youtube', ['en' => 'YouTube', 'fa' => 'یوتیوب', 'ar' => 'يوتيوب'], 'https://youtube.com/@sahramarketing', 'youtube', 3],
            ['whatsapp', ['en' => 'WhatsApp', 'fa' => 'واتساپ', 'ar' => 'واتساب'], 'https://wa.me/96777811213', 'message-circle', 4],
        ];

        foreach ($links as [$platform, $labels, $url, $icon, $order]) {
            SocialLink::updateOrCreate(
                ['platform' => $platform],
                [
                    'label' => $labels['en'],
                    'url' => $url,
                    'icon' => $icon,
                    'sort_order' => $order,
                    'is_active' => true,
                ],
            );
        }

        SocialLink::query()
            ->whereNotIn('platform', array_column($links, 0))
            ->delete();

        $this->socialLabels = collect($links)
            ->keyBy(fn (array $link): string => $link[0])
            ->map(fn (array $link): array => $link[1])
            ->all();
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

        // Arabic labels are the header frame's own strings (ar home 1365:10094):
        // fully vocalised, and possessive where the en frame is bare — خَدَمَاتُنَا
        // / رُؤَانَا, not الخدمات / رؤى. The vocalisation is deliberate and scoped
        // to this menu: the footer frame 1365:10075 sets the same links plain.
        $items = [
            ['home', ['en' => 'Home', 'fa' => 'خانه', 'ar' => 'الرَّئِيسِيَّةُ'], false],
            ['work.index', ['en' => 'Work', 'fa' => 'نمونه‌کارها', 'ar' => 'أَعْمَالُنَا'], false],
            ['services', ['en' => 'Service', 'fa' => 'خدمات', 'ar' => 'خَدَمَاتُنَا'], false],
            ['insights.index', ['en' => 'Insight', 'fa' => 'بینش', 'ar' => 'رُؤَانَا'], false],
            ['about', ['en' => 'About', 'fa' => 'درباره ما', 'ar' => 'مَن نَحْنُ'], false],
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
                    // Footer frame 1365:10075 — plain (unvocalised) forms, and
                    // its own wording: المشاريع / الرؤى / تواصل معنا.
                    ['work.index', ['en' => 'Work', 'fa' => 'نمونه‌کارها', 'ar' => 'المشاريع']],
                    ['insights.index', ['en' => 'Insight', 'fa' => 'بینش', 'ar' => 'الرؤى']],
                    ['about', ['en' => 'About', 'fa' => 'درباره ما', 'ar' => 'من نحن']],
                    ['contact', ['en' => 'Contact', 'fa' => 'تماس', 'ar' => 'تواصل معنا']],
                ],
            ],
            [
                'labels' => ['en' => 'Social Links', 'fa' => 'شبکه‌های اجتماعی', 'ar' => 'روابط التواصل'],
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

                        $labels = $this->socialLabels[$link->platform]
                            ?? ['en' => $link->label, 'fa' => $link->label, 'ar' => $link->label];

                        $child->setTranslations(
                            collect($labels)
                                ->map(fn (string $label): array => ['label' => $label])
                                ->all(),
                        );
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
