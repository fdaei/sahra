<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Models\Industry;
use App\Models\PageSection;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * The six case studies from the Figma projects grid (1362:7198) plus the
 * fully-detailed Cheshmeh case study (1323:7541).
 */
final class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $industries = Industry::query()->withTranslations()->get()->keyBy(
            fn (Industry $i): string => (string) $i->getTranslation('slug', 'en'),
        );

        $projects = [
            [
                'slug' => 'baghche-branding', 'industry' => 'food-beverage', 'year' => '2024',
                'instagram' => 'baghche', 'cover' => 'projects/baghche.webp',
                'en' => ['title' => 'Baghche', 'subtitle' => 'Healthy food, honestly presented', 'excerpt' => 'Branding and content support for a healthy food brand focused on freshness, trust, and everyday convenience.'],
                'fa' => ['title' => 'باغچه', 'subtitle' => 'غذای سالم، صادقانه ارائه‌شده', 'excerpt' => 'پشتیبانی برندینگ و محتوا برای برند غذای سالم با تمرکز بر تازگی، اعتماد و راحتی روزمره.'],
                'ar' => ['title' => 'باغتشه', 'subtitle' => 'طعام صحي بعرض صادق', 'excerpt' => 'دعم الهوية والمحتوى لعلامة أطعمة صحية تركز على النضارة والثقة والراحة اليومية.'],
            ],
            [
                'slug' => 'kerman-motors', 'industry' => 'automotive', 'year' => '2024',
                'instagram' => null, 'cover' => 'projects/kerman-motors.webp',
                'en' => ['title' => 'Kerman Motors', 'subtitle' => 'Factory-price sale campaign', 'excerpt' => 'Campaign visuals and promotional creative for a factory-price sales launch.'],
                'fa' => ['title' => 'کرمان موتورز', 'subtitle' => 'کمپین فروش با قیمت کارخانه', 'excerpt' => 'بصری‌های کمپین و خلاقیت تبلیغاتی برای راه‌اندازی فروش با قیمت کارخانه.'],
                'ar' => ['title' => 'كرمان موتورز', 'subtitle' => 'حملة بيع بسعر المصنع', 'excerpt' => 'مرئيات حملة وإبداع ترويجي لإطلاق بيع بسعر المصنع.'],
            ],
            [
                'slug' => 'fakhar-clinic', 'industry' => 'healthcare', 'year' => '2024',
                'instagram' => 'fakharclinic', 'cover' => 'projects/fakhar-clinic.webp',
                'en' => ['title' => 'Fakhar Medical & Dental Clinic', 'subtitle' => 'Comprehensive care, one clear voice', 'excerpt' => 'Brand direction and content for a comprehensive medical services provider.'],
                'fa' => ['title' => 'کلینیک پزشکی و دندانپزشکی فخر', 'subtitle' => 'مراقبت جامع، یک صدای شفاف', 'excerpt' => 'جهت‌گیری برند و محتوا برای ارائه‌دهنده خدمات پزشکی جامع.'],
                'ar' => ['title' => 'عيادة فخر الطبية وطب الأسنان', 'subtitle' => 'رعاية شاملة بصوت واحد واضح', 'excerpt' => 'توجيه العلامة والمحتوى لمزود خدمات طبية شاملة.'],
            ],
            [
                'slug' => 'plus-protein', 'industry' => 'food-beverage', 'year' => '2023',
                'instagram' => 'plusprotein', 'cover' => 'projects/plus-protein.webp',
                'en' => ['title' => 'Plus Protein', 'subtitle' => 'A mark built for the gym bag', 'excerpt' => 'Logo and packaging-facing brand identity for a protein products company.'],
                'fa' => ['title' => 'پلاس پروتئین', 'subtitle' => 'نشانی ساخته‌شده برای کیف ورزشی', 'excerpt' => 'هویت برند برای لوگو و بسته‌بندی یک شرکت محصولات پروتئینی.'],
                'ar' => ['title' => 'بلس بروتين', 'subtitle' => 'شعار صُمم لحقيبة الرياضة', 'excerpt' => 'هوية العلامة للشعار والتغليف لشركة منتجات بروتين.'],
            ],
            [
                'slug' => 'karsa-tourism', 'industry' => 'travel', 'year' => '2023',
                'instagram' => 'karsatravel', 'cover' => 'projects/karsa-tourism.webp',
                'en' => ['title' => 'Karsa Tourism Services', 'subtitle' => 'Booking made to feel personal', 'excerpt' => 'Branding and campaign visuals for a travel and tourism services company.'],
                'fa' => ['title' => 'خدمات گردشگری کرسا', 'subtitle' => 'رزروی با حس شخصی', 'excerpt' => 'برندینگ و بصری‌های کمپین برای شرکت خدمات گردشگری.'],
                'ar' => ['title' => 'خدمات كارسا السياحية', 'subtitle' => 'حجز يبدو شخصياً', 'excerpt' => 'الهوية ومرئيات الحملة لشركة خدمات سياحية وسفر.'],
            ],
            [
                'slug' => 'cheshmeh-beauty', 'industry' => 'beauty-wellness', 'year' => '2024',
                'instagram' => 'cheshmeh.beauty', 'cover' => 'projects/cheshmeh.webp',
                'banner' => 'projects/cheshmeh-banner.webp', 'featured' => true,
                'en' => [
                    'title' => 'Cheshmeh Beauty Clinic', 'subtitle' => 'A calmer, more trusted identity',
                    'excerpt' => 'A full digital identity refresh for a beauty and dental clinic.',
                    'challenge' => 'Cheshmeh had strong services, but its digital presence did not clearly reflect the trust, calmness, and clarity people expect from a beauty clinic.',
                    'challenge_points' => ['No clear content direction', 'Inconsistent visual identity', 'Unclear brand presence'],
                    'results_summary' => "The project helped Cheshmeh build a clearer and more consistent digital presence. Through a refined visual direction and strategic content approach, the brand created stronger audience trust and engagement.",
                ],
                'fa' => [
                    'title' => 'کلینیک زیبایی چشمه', 'subtitle' => 'هویتی آرام‌تر و قابل‌اعتمادتر',
                    'excerpt' => 'بازطراحی کامل هویت دیجیتال برای یک کلینیک زیبایی و دندانپزشکی.',
                    'challenge' => 'چشمه خدمات قوی داشت، اما حضور دیجیتالش اعتماد، آرامش و شفافیتی را که از یک کلینیک زیبایی انتظار می‌رود، منعکس نمی‌کرد.',
                    'challenge_points' => ['نبود جهت‌گیری شفاف محتوایی', 'هویت بصری ناهماهنگ', 'حضور برند نامشخص'],
                    'results_summary' => 'این پروژه به چشمه کمک کرد حضور دیجیتالی شفاف‌تر و یکدست‌تری بسازد. با جهت‌گیری بصری بازتعریف‌شده و رویکرد محتوایی استراتژیک، برند اعتماد و تعامل قوی‌تری از مخاطبان به دست آورد.',
                ],
                'ar' => [
                    'title' => 'عيادة تجميل تشيشمه', 'subtitle' => 'هوية أكثر هدوءاً وثقة',
                    'excerpt' => 'تجديد كامل للهوية الرقمية لعيادة تجميل وأسنان.',
                    'challenge' => 'كانت لدى تشيشمه خدمات قوية، لكن حضورها الرقمي لم يعكس بوضوح الثقة والهدوء والوضوح التي يتوقعها الناس من عيادة تجميل.',
                    'challenge_points' => ['لا اتجاه واضح للمحتوى', 'هوية بصرية غير متسقة', 'حضور غير واضح للعلامة'],
                    'results_summary' => 'ساعد المشروع تشيشمه على بناء حضور رقمي أوضح وأكثر اتساقاً. من خلال توجيه بصري مُحسّن ونهج محتوى استراتيجي، بنت العلامة ثقة وتفاعلاً أقوى مع الجمهور.',
                ],
            ],
        ];

        foreach ($projects as $index => $data) {
            $project = Project::updateOrCreate(
                ['id' => $index + 1],
                [
                    'industry_id' => $industries->get($data['industry'])?->id,
                    'status' => PublicationStatus::Published,
                    'published_at' => now()->subDays(count($projects) - $index),
                    'sort_order' => $index,
                    'is_featured' => $data['featured'] ?? false,
                    'year' => $data['year'],
                    'instagram_handle' => $data['instagram'],
                    'cover_path' => $data['cover'],
                    'banner_path' => $data['banner'] ?? $data['cover'],
                ],
            );

            $project->setTranslations([
                'en' => array_merge(['slug' => $data['slug']], $data['en']),
                'fa' => array_merge(['slug' => $this->faSlug($data['slug'])], $data['fa']),
                'ar' => array_merge(['slug' => $this->arSlug($data['slug'])], $data['ar']),
            ]);

            // Attach a couple of services to each project.
            $project->services()->sync(
                Service::query()->inRandomOrder()->limit(2)->pluck('id'),
            );

            if (($data['featured'] ?? false) === true) {
                $this->cheshmehDetail($project);
            }
        }
    }

    /**
     * Full detail sections for the one project the Figma file expands in
     * full (1323:7541): goals, strategy, deliverables, results.
     */
    private function cheshmehDetail(Project $project): void
    {
        $project->sections()->delete();

        $goals = $this->section($project, SectionType::Goals, 0);
        $this->items($goals, [
            ['en' => ['title' => 'Calm Identity', 'description' => 'Softer brand perception'], 'fa' => ['title' => 'هویت آرام', 'description' => 'برداشتی نرم‌تر از برند'], 'ar' => ['title' => 'هوية هادئة', 'description' => 'إدراك أنعم للعلامة']],
            ['en' => ['title' => 'Clear Direction', 'description' => 'A consistent visual system'], 'fa' => ['title' => 'جهت شفاف', 'description' => 'سیستم بصری یکدست'], 'ar' => ['title' => 'اتجاه واضح', 'description' => 'نظام بصري متسق']],
            ['en' => ['title' => 'Trusted Presence', 'description' => 'Building audience trust'], 'fa' => ['title' => 'حضور قابل‌اعتماد', 'description' => 'ساخت اعتماد مخاطب'], 'ar' => ['title' => 'حضور موثوق', 'description' => 'بناء ثقة الجمهور']],
            ['en' => ['title' => 'Meaningful Content', 'description' => 'Better audience connection'], 'fa' => ['title' => 'محتوای معنادار', 'description' => 'ارتباط بهتر با مخاطب'], 'ar' => ['title' => 'محتوى هادف', 'description' => 'تواصل أفضل مع الجمهور']],
        ]);

        $strategy = $this->section($project, SectionType::Strategy, 1);
        $this->items($strategy, [
            ['en' => ['title' => 'Visual System', 'description' => 'We developed a cleaner and more consistent visual language, focused on color, composition, soft hierarchy, and a more recognizable brand presence.'], 'fa' => ['title' => 'سیستم بصری', 'description' => 'زبان بصری‌ای شفاف‌تر و یکدست‌تر با تمرکز بر رنگ، ترکیب‌بندی و سلسله‌مراتب نرم توسعه دادیم.'], 'ar' => ['title' => 'النظام البصري', 'description' => 'طورنا لغة بصرية أنظف وأكثر اتساقاً، تركز على اللون والتكوين والتراتب الناعم.']],
            ['en' => ['title' => 'Content Direction', 'description' => 'The content was organized around clear pillars: brand story, product value, lifestyle moments, audience education, and trust-building messages.'], 'fa' => ['title' => 'جهت‌گیری محتوا', 'description' => 'محتوا حول ستون‌های شفافی سازمان یافت: داستان برند، ارزش محصول، لحظات سبک زندگی و پیام‌های اعتمادساز.'], 'ar' => ['title' => 'توجيه المحتوى', 'description' => 'نُظّم المحتوى حول ركائز واضحة: قصة العلامة وقيمة المنتج ولحظات نمط الحياة ورسائل بناء الثقة.']],
            ['en' => ['title' => 'Publishing Flow', 'description' => 'A structured publishing rhythm was created to help the brand stay active, consistent, and aligned across posts, stories, and campaign content.'], 'fa' => ['title' => 'جریان انتشار', 'description' => 'ریتم انتشار ساختارمندی ایجاد شد تا برند در پست‌ها، استوری‌ها و محتوای کمپین فعال و یکدست بماند.'], 'ar' => ['title' => 'تدفق النشر', 'description' => 'أُنشئ إيقاع نشر منظم ليبقى العلامة نشطة ومتسقة عبر المنشورات والقصص ومحتوى الحملات.']],
            ['en' => ['title' => 'Audience Focus', 'description' => 'The messaging was shaped around people looking for quality, trust, simplicity, and a brand they could connect with beyond the product itself.'], 'fa' => ['title' => 'تمرکز بر مخاطب', 'description' => 'پیام‌رسانی حول افرادی شکل گرفت که به دنبال کیفیت، اعتماد، سادگی و ارتباطی فراتر از محصول بودند.'], 'ar' => ['title' => 'التركيز على الجمهور', 'description' => 'صيغت الرسائل حول أشخاص يبحثون عن الجودة والثقة والبساطة وعلامة يتواصلون معها بما يتجاوز المنتج.']],
        ]);

        $deliverables = $this->section($project, SectionType::Deliverables, 2);
        $this->items($deliverables, [
            ['en' => ['title' => 'Brand Direction', 'description' => 'A clearer direction for how Cheshmeh should communicate visually and verbally.'], 'fa' => ['title' => 'جهت‌گیری برند', 'description' => 'جهتی شفاف‌تر برای نحوه ارتباط بصری و کلامی چشمه.'], 'ar' => ['title' => 'توجيه العلامة', 'description' => 'اتجاه أوضح لكيفية تواصل تشيشمه بصرياً ولفظياً.']],
            ['en' => ['title' => 'Content Strategy', 'description' => "Content pillars and messaging themes designed around the brand's audience and business goals."], 'fa' => ['title' => 'استراتژی محتوا', 'description' => 'ستون‌های محتوا و مضامین پیام طراحی‌شده حول مخاطب و اهداف کسب‌وکار.'], 'ar' => ['title' => 'استراتيجية المحتوى', 'description' => 'ركائز محتوى وموضوعات رسائل مصممة حول جمهور العلامة وأهداف العمل.']],
            ['en' => ['title' => 'Visual System', 'description' => 'Reusable layouts, visual rules, and design patterns for social media.'], 'fa' => ['title' => 'سیستم بصری', 'description' => 'قالب‌ها، قواعد بصری و الگوهای طراحی قابل‌استفاده مجدد برای شبکه‌های اجتماعی.'], 'ar' => ['title' => 'النظام البصري', 'description' => 'تخطيطات وقواعد بصرية وأنماط تصميم قابلة لإعادة الاستخدام لوسائل التواصل.']],
            ['en' => ['title' => 'Content Calendar', 'description' => 'A structured monthly content plan for posts, stories, and campaigns.'], 'fa' => ['title' => 'تقویم محتوا', 'description' => 'برنامه ماهانه ساختارمند محتوا برای پست‌ها، استوری‌ها و کمپین‌ها.'], 'ar' => ['title' => 'تقويم المحتوى', 'description' => 'خطة محتوى شهرية منظمة للمنشورات والقصص والحملات.']],
            ['en' => ['title' => 'Story Templates', 'description' => 'Flexible story formats for product highlights, brand moments, FAQs, and engagement.'], 'fa' => ['title' => 'قالب‌های استوری', 'description' => 'فرمت‌های انعطاف‌پذیر استوری برای معرفی محصول، لحظات برند و تعامل.'], 'ar' => ['title' => 'قوالب القصص', 'description' => 'صيغ قصص مرنة لإبراز المنتج ولحظات العلامة والأسئلة الشائعة والتفاعل.']],
            ['en' => ['title' => 'Campaign Ideas', 'description' => 'Creative concepts to support seasonal promotions, awareness, and audience interaction.'], 'fa' => ['title' => 'ایده‌های کمپین', 'description' => 'مفاهیم خلاقانه برای پشتیبانی از پروموشن‌های فصلی و تعامل مخاطب.'], 'ar' => ['title' => 'أفكار الحملات', 'description' => 'مفاهيم إبداعية لدعم العروض الموسمية والتوعية وتفاعل الجمهور.']],
        ]);

        $results = $this->section($project, SectionType::Results, 3);
        $this->items($results, [
            ['en' => ['value' => '+189%', 'title' => 'ROI'], 'fa' => ['value' => '+۱۸۹٪', 'title' => 'بازگشت سرمایه'], 'ar' => ['value' => '+189%', 'title' => 'عائد الاستثمار']],
            ['en' => ['value' => '+154%', 'title' => 'Reach'], 'fa' => ['value' => '+۱۵۴٪', 'title' => 'دسترسی'], 'ar' => ['value' => '+154%', 'title' => 'الوصول']],
            ['en' => ['value' => '+189%', 'title' => 'Interaction'], 'fa' => ['value' => '+۱۸۹٪', 'title' => 'تعامل'], 'ar' => ['value' => '+189%', 'title' => 'التفاعل']],
            ['en' => ['value' => '+256%', 'title' => 'Follower'], 'fa' => ['value' => '+۲۵۶٪', 'title' => 'دنبال‌کننده'], 'ar' => ['value' => '+256%', 'title' => 'المتابعون']],
            ['en' => ['value' => '+72%', 'title' => 'View'], 'fa' => ['value' => '+۷۲٪', 'title' => 'بازدید'], 'ar' => ['value' => '+72%', 'title' => 'المشاهدات']],
        ]);

        $project->update([
            'before_image_path' => 'projects/cheshmeh-before.webp',
            'after_image_path' => 'projects/cheshmeh-after.webp',
        ]);
    }

    private function section(Project $project, SectionType $type, int $order): PageSection
    {
        return $project->sections()->create([
            'type' => $type,
            'sort_order' => $order,
            'is_visible' => true,
        ]);
    }

    /**
     * @param  array<int, array<string, array<string, string>>>  $items
     */
    private function items(PageSection $section, array $items): void
    {
        foreach ($items as $index => $translations) {
            $item = $section->items()->create(['sort_order' => $index, 'is_visible' => true]);
            $item->setTranslations($translations);
        }
    }

    private function faSlug(string $enSlug): string
    {
        return match ($enSlug) {
            'baghche-branding' => 'باغچه',
            'kerman-motors' => 'کرمان-موتورز',
            'fakhar-clinic' => 'کلینیک-فخر',
            'plus-protein' => 'پلاس-پروتئین',
            'karsa-tourism' => 'کرسا-توریسم',
            'cheshmeh-beauty' => 'چشمه-بیوتی',
            default => $enSlug,
        };
    }

    private function arSlug(string $enSlug): string
    {
        return match ($enSlug) {
            'baghche-branding' => 'باغتشه',
            'kerman-motors' => 'كرمان-موتورز',
            'fakhar-clinic' => 'عيادة-فخر',
            'plus-protein' => 'بلس-بروتين',
            'karsa-tourism' => 'كارسا-تورزم',
            'cheshmeh-beauty' => 'تشيشمه-بيوتي',
            default => $enSlug,
        };
    }
}
