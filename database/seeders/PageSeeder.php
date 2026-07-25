<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Pages and their content sections.
 *
 * Copy comes from the Figma frames listed per section. FA/AR strings are
 * working translations pending native review (docs/IMPLEMENTATION-LOG.md).
 */
final class PageSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->home();
            $this->about();
            $this->work();
            $this->services();
            $this->insights();
            $this->contact();
            $this->legal();
        });
    }

    /**
     * Home — Figma 1419:9192.
     */
    private function home(): void
    {
        $page = $this->page('home', [
            'en' => [
                'title' => 'We build content systems for brands ready to grow',
                'seo_title' => 'Sahra — Digital Marketing Agency in Muscat',
                'seo_description' => 'Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.',
            ],
            'fa' => [
                'title' => 'ما سیستم‌های محتوایی می‌سازیم برای برندهایی که آماده رشدند',
                'seo_title' => 'صحرا — آژانس بازاریابی دیجیتال در مسقط',
                'seo_description' => 'صحرا به کسب‌وکارها در عمان کمک می‌کند حضور برند قوی‌تری بسازند.',
            ],
            'ar' => [
                'title' => 'نبني أنظمة محتوى للعلامات التجارية المستعدة للنمو',
                'seo_title' => 'صحراء — وكالة تسويق رقمي في مسقط',
                'seo_description' => 'تساعد صحراء الشركات في عُمان على بناء حضور أقوى لعلامتها التجارية.',
            ],
        ]);

        $page->sections()->delete();

        // Hero — 1419:9194. Copy verified against the live Figma node text
        // runs (corrected from an earlier approximation — the real CTA order
        // is Explore Projects (primary) then Start a Conversation (secondary),
        // and "marketing systems" is a distinct gradient-styled phrase).
        $this->section($page, SectionType::Hero, 0, [
            'en' => [
                'eyebrow' => 'Digital Marketing Agency in Muscat',
                'title' => 'We build',
                'subtitle' => 'Sahra connects strategy, identity, content, and campaigns into one clear direction for business growth',
                'primary_cta_label' => 'Explore Projects',
                'primary_cta_url' => '/work',
                'secondary_cta_label' => 'Start a Conversation',
                'secondary_cta_url' => '/contact',
                'image_alt' => 'Golden desert dunes meeting the horizon at sunrise',
                'content' => 'marketing systems',
            ],
            'fa' => [
                'eyebrow' => 'آژانس بازاریابی دیجیتال در مسقط',
                'title' => 'ما می‌سازیم',
                'subtitle' => 'صحرا استراتژی، هویت، محتوا و کمپین را در یک مسیر شفاف برای رشد کسب‌وکار به‌هم متصل می‌کند.',
                'primary_cta_label' => 'مشاهده پروژه‌ها',
                'primary_cta_url' => '/work',
                'secondary_cta_label' => 'شروع گفتگو',
                'secondary_cta_url' => '/contact',
                'image_alt' => 'تپه‌های طلایی کویر در افق هنگام طلوع',
                'content' => 'سیستم‌های بازاریابی',
            ],
            'ar' => [
                'eyebrow' => 'وكالة تسويق رقمي في مسقط',
                'title' => 'نبني',
                'subtitle' => 'تربط صحراء الاستراتيجية والهوية والمحتوى والحملات في اتجاه واحد واضح لنمو الأعمال.',
                'primary_cta_label' => 'شاهد المشاريع',
                'primary_cta_url' => '/work',
                'secondary_cta_label' => 'ابدأ محادثة',
                'secondary_cta_url' => '/contact',
                'image_alt' => 'كثبان رملية ذهبية عند الأفق وقت الشروق',
                'content' => 'أنظمة التسويق',
            ],
        ]);

        // KPI strip — 1419:9318
        $kpi = $this->section($page, SectionType::Kpi, 1, [
            'en' => ['title' => 'Results that compound'],
            'fa' => ['title' => 'نتایجی که انباشته می‌شوند'],
            'ar' => ['title' => 'نتائج تتراكم'],
        ]);

        $this->items($kpi, [
            [
                'en' => ['value' => '+70k', 'title' => 'Followers Gained from a Single Reel'],
                'fa' => ['value' => '+۷۰ هزار', 'title' => 'دنبال‌کننده از یک ریلز'],
                'ar' => ['value' => '+70k', 'title' => 'متابع من مقطع واحد'],
            ],
            [
                'en' => ['value' => '+40', 'title' => 'Brands Supported'],
                'fa' => ['value' => '+۴۰', 'title' => 'برند پشتیبانی‌شده'],
                'ar' => ['value' => '+40', 'title' => 'علامة تجارية مدعومة'],
            ],
            [
                'en' => ['value' => '+250', 'title' => 'Projects Delivered'],
                'fa' => ['value' => '+۲۵۰', 'title' => 'پروژه تحویل‌شده'],
                'ar' => ['value' => '+250', 'title' => 'مشروع منجز'],
            ],
        ]);

        // Trust proof — 1419:9205
        $this->section($page, SectionType::TrustProof, 2, [
            'en' => ['title' => 'Trusted by brands across Oman and beyond'],
            'fa' => ['title' => 'مورد اعتماد برندها در عمان و فراتر از آن'],
            'ar' => ['title' => 'موضع ثقة علامات تجارية في عُمان وخارجها'],
        ]);

        // Services cloud — 1419:9279
        $this->section($page, SectionType::ServicesCloud, 3, [
            'en' => [
                'eyebrow' => 'Our services',
                'title' => 'Four systems, one direction',
                'description' => 'Everything we do is built to give your brand clarity, structure, and long-term direction.',
            ],
            'fa' => [
                'eyebrow' => 'خدمات ما',
                'title' => 'چهار سیستم، یک مسیر',
                'description' => 'هر آنچه انجام می‌دهیم برای ایجاد شفافیت، ساختار و مسیر بلندمدت برند شماست.',
            ],
            'ar' => [
                'eyebrow' => 'خدماتنا',
                'title' => 'أربعة أنظمة، اتجاه واحد',
                'description' => 'كل ما نقوم به مصمم لمنح علامتك التجارية وضوحاً وبنية واتجاهاً طويل الأمد.',
            ],
        ]);

        // Lead magnet — 1419:9322
        $this->section($page, SectionType::LeadMagnet, 4, [
            'en' => [
                'title' => 'Download our free marketing checklist for businesses in Oman.',
                'primary_cta_label' => 'Get checklist',
            ],
            'fa' => [
                'title' => 'چک‌لیست رایگان بازاریابی ما را برای کسب‌وکارها در عمان دریافت کنید.',
                'primary_cta_label' => 'دریافت چک‌لیست',
            ],
            'ar' => [
                'title' => 'حمّل قائمة التسويق المجانية للشركات في عُمان.',
                'primary_cta_label' => 'احصل على القائمة',
            ],
        ]);

        // Projects showcase — 1419:9216
        $this->section($page, SectionType::ProjectsShowcase, 5, [
            'en' => [
                'eyebrow' => 'Our Projects',
                'title' => 'Where Strategy Becomes Visible',
                'primary_cta_label' => 'View all work',
                'primary_cta_url' => '/work',
            ],
            'fa' => [
                'eyebrow' => 'پروژه‌های ما',
                'title' => 'جایی که استراتژی دیده می‌شود',
                'primary_cta_label' => 'مشاهده همه نمونه‌کارها',
                'primary_cta_url' => '/work',
            ],
            'ar' => [
                'eyebrow' => 'مشاريعنا',
                'title' => 'حيث تصبح الاستراتيجية مرئية',
                'primary_cta_label' => 'شاهد كل الأعمال',
                'primary_cta_url' => '/work',
            ],
        ]);

        // Process — 1419:9302
        $process = $this->section($page, SectionType::Process, 6, [
            'en' => ['eyebrow' => 'How we work', 'title' => 'A process built on clarity'],
            'fa' => ['eyebrow' => 'روش کار ما', 'title' => 'فرایندی بر پایه شفافیت'],
            'ar' => ['eyebrow' => 'كيف نعمل', 'title' => 'عملية مبنية على الوضوح'],
        ]);

        $this->items($process, [
            [
                'en' => ['value' => '01', 'title' => 'Discovery', 'description' => 'Understanding your business, audience, and goals.'],
                'fa' => ['value' => '۰۱', 'title' => 'کشف', 'description' => 'درک کسب‌وکار، مخاطب و اهداف شما.'],
                'ar' => ['value' => '01', 'title' => 'الاكتشاف', 'description' => 'فهم عملك وجمهورك وأهدافك.'],
            ],
            [
                'en' => ['value' => '02', 'title' => 'Direction', 'description' => 'Defining the strategic foundation before any design begins.'],
                'fa' => ['value' => '۰۲', 'title' => 'جهت‌گیری', 'description' => 'تعیین بنیان استراتژیک پیش از شروع طراحی.'],
                'ar' => ['value' => '02', 'title' => 'الاتجاه', 'description' => 'تحديد الأساس الاستراتيجي قبل بدء التصميم.'],
            ],
            [
                'en' => ['value' => '03', 'title' => 'System', 'description' => 'Building reusable visual and content rules.'],
                'fa' => ['value' => '۰۳', 'title' => 'سیستم', 'description' => 'ساخت قواعد بصری و محتوایی قابل استفاده مجدد.'],
                'ar' => ['value' => '03', 'title' => 'النظام', 'description' => 'بناء قواعد بصرية ومحتوى قابلة لإعادة الاستخدام.'],
            ],
            [
                'en' => ['value' => '04', 'title' => 'Production', 'description' => 'Creating content that fits the system, not the trend.'],
                'fa' => ['value' => '۰۴', 'title' => 'تولید', 'description' => 'ساخت محتوایی که با سیستم هماهنگ است، نه با ترند.'],
                'ar' => ['value' => '04', 'title' => 'الإنتاج', 'description' => 'إنشاء محتوى يناسب النظام لا الموضة.'],
            ],
            [
                'en' => ['value' => '05', 'title' => 'Publishing', 'description' => 'A consistent rhythm across every platform.'],
                'fa' => ['value' => '۰۵', 'title' => 'انتشار', 'description' => 'ریتمی یکنواخت در همه پلتفرم‌ها.'],
                'ar' => ['value' => '05', 'title' => 'النشر', 'description' => 'إيقاع ثابت عبر كل المنصات.'],
            ],
            [
                'en' => ['value' => '06', 'title' => 'Growth', 'description' => 'Measuring, refining, and compounding results.'],
                'fa' => ['value' => '۰۶', 'title' => 'رشد', 'description' => 'سنجش، اصلاح و انباشت نتایج.'],
                'ar' => ['value' => '06', 'title' => 'النمو', 'description' => 'القياس والتحسين ومراكمة النتائج.'],
            ],
        ]);

        // Packages — 1419:9323. Empty in the design (audit gap G4): seeded
        // hidden so an editor can populate it without a code change.
        $this->section($page, SectionType::Packages, 7, [
            'en' => ['title' => 'Packages'],
            'fa' => ['title' => 'بسته‌ها'],
            'ar' => ['title' => 'الباقات'],
        ], visible: false);

        // Why us — 1419:9230
        $why = $this->section($page, SectionType::WhyUs, 8, [
            'en' => ['eyebrow' => 'Why Sahra', 'title' => 'Why brands choose to work with us'],
            'fa' => ['eyebrow' => 'چرا صحرا', 'title' => 'چرا برندها ما را انتخاب می‌کنند'],
            'ar' => ['eyebrow' => 'لماذا صحراء', 'title' => 'لماذا تختار العلامات التجارية العمل معنا'],
        ]);

        $this->items($why, [
            [
                'en' => ['title' => 'Creativity', 'description' => 'Ideas grounded in strategy, not decoration.'],
                'fa' => ['title' => 'خلاقیت', 'description' => 'ایده‌هایی مبتنی بر استراتژی، نه تزئین.'],
                'ar' => ['title' => 'الإبداع', 'description' => 'أفكار مبنية على الاستراتيجية لا الزخرفة.'],
            ],
            [
                'en' => ['title' => 'Reliability', 'description' => 'Consistent delivery on an agreed rhythm.'],
                'fa' => ['title' => 'اتکاپذیری', 'description' => 'تحویل منظم بر اساس ریتم توافق‌شده.'],
                'ar' => ['title' => 'الموثوقية', 'description' => 'تسليم منتظم وفق إيقاع متفق عليه.'],
            ],
            [
                'en' => ['title' => 'Innovation', 'description' => 'New formats tested against real business goals.'],
                'fa' => ['title' => 'نوآوری', 'description' => 'قالب‌های تازه، سنجیده با اهداف واقعی کسب‌وکار.'],
                'ar' => ['title' => 'الابتكار', 'description' => 'صيغ جديدة تُختبر مقابل أهداف عمل حقيقية.'],
            ],
            [
                'en' => ['title' => 'Clarity', 'description' => 'One connected story instead of scattered posts.'],
                'fa' => ['title' => 'شفافیت', 'description' => 'یک روایت پیوسته به‌جای پست‌های پراکنده.'],
                'ar' => ['title' => 'الوضوح', 'description' => 'قصة واحدة مترابطة بدل منشورات مبعثرة.'],
            ],
        ]);

        // Reviews — 1419:9243
        $this->section($page, SectionType::Reviews, 9, [
            'en' => ['eyebrow' => 'Testimonials', 'title' => 'What our customers tell about us'],
            'fa' => ['eyebrow' => 'نظرات مشتریان', 'title' => 'مشتریان درباره ما چه می‌گویند'],
            'ar' => ['eyebrow' => 'آراء العملاء', 'title' => 'ماذا يقول عملاؤنا عنا'],
        ]);

        // Insights — 1419:9258
        $this->section($page, SectionType::Insights, 10, [
            'en' => [
                'eyebrow' => 'Insights',
                'title' => 'Insights for Brands Ready to Grow',
                'primary_cta_label' => 'Read all articles',
                'primary_cta_url' => '/insights',
            ],
            'fa' => [
                'eyebrow' => 'بینش',
                'title' => 'بینش برای برندهایی که آماده رشدند',
                'primary_cta_label' => 'خواندن همه مقالات',
                'primary_cta_url' => '/insights',
            ],
            'ar' => [
                'eyebrow' => 'رؤى',
                'title' => 'رؤى للعلامات التجارية المستعدة للنمو',
                'primary_cta_label' => 'اقرأ كل المقالات',
                'primary_cta_url' => '/insights',
            ],
        ]);

        // FAQ — 1419:9272
        $this->section($page, SectionType::Faq, 11, [
            'en' => ['eyebrow' => 'FAQ', 'title' => 'Questions we hear often'],
            'fa' => ['eyebrow' => 'پرسش‌های متداول', 'title' => 'پرسش‌هایی که زیاد می‌شنویم'],
            'ar' => ['eyebrow' => 'الأسئلة الشائعة', 'title' => 'أسئلة نسمعها كثيراً'],
        ]);

        // Final CTA — 1419:9333
        $this->finalCta($page, 12);
    }

    /**
     * About — Figma 908:1576.
     */
    private function about(): void
    {
        $page = $this->page('about', [
            'en' => [
                'title' => 'We are Sahra',
                'subtitle' => 'About us',
                'seo_title' => 'About Sahra — A strategy-led agency in Oman',
            ],
            'fa' => [
                'title' => 'ما صحرا هستیم',
                'subtitle' => 'درباره ما',
                'seo_title' => 'درباره صحرا — آژانسی استراتژی‌محور در عمان',
            ],
            'ar' => [
                'title' => 'نحن صحراء',
                'subtitle' => 'من نحن',
                'seo_title' => 'عن صحراء — وكالة قائمة على الاستراتيجية في عُمان',
            ],
        ]);

        $page->sections()->delete();

        $this->section($page, SectionType::AboutHero, 0, [
            'en' => [
                'eyebrow' => 'About us',
                'title' => 'We are Sahra — a strategy led digital marketing agency rooted in Oman',
                'description' => 'We help brands build stronger digital presence through content, branding, social media, and creative direction.',
                'image_alt' => 'Glass arch sculpture holding golden sand dunes and a sun disc',
            ],
            'fa' => [
                'eyebrow' => 'درباره ما',
                'title' => 'ما صحرا هستیم — آژانس بازاریابی دیجیتال استراتژی‌محور با ریشه در عمان',
                'description' => 'ما به برندها کمک می‌کنیم از طریق محتوا، برندینگ، شبکه‌های اجتماعی و جهت‌گیری خلاق حضور دیجیتال قوی‌تری بسازند.',
                'image_alt' => 'مجسمه شیشه‌ای قوسی با تپه‌های شنی طلایی و قرص خورشید',
            ],
            'ar' => [
                'eyebrow' => 'من نحن',
                'title' => 'نحن صحراء — وكالة تسويق رقمي قائمة على الاستراتيجية من عُمان',
                'description' => 'نساعد العلامات التجارية على بناء حضور رقمي أقوى عبر المحتوى والهوية ووسائل التواصل والتوجيه الإبداعي.',
                'image_alt' => 'منحوتة زجاجية مقوسة تحتضن كثباناً رملية ذهبية وقرص شمس',
            ],
        ]);

        $this->section($page, SectionType::Story, 1, [
            'en' => [
                'title' => 'The Story Behind Sahra',
                'description' => 'Sahra began with a simple belief: brands deserve more than scattered content and short-term visuals.',
                'content' => 'We help businesses present themselves with more quality, clarity, and consistency — bringing content production, visual direction, branding, and social media management together to build a stronger digital presence.',
            ],
            'fa' => [
                'title' => 'داستان صحرا',
                'description' => 'صحرا با باوری ساده آغاز شد: برندها شایسته چیزی بیش از محتوای پراکنده و تصاویر کوتاه‌مدت هستند.',
                'content' => 'ما به کسب‌وکارها کمک می‌کنیم خود را با کیفیت، شفافیت و ثبات بیشتری معرفی کنند — با گردآوردن تولید محتوا، جهت‌گیری بصری، برندینگ و مدیریت شبکه‌های اجتماعی.',
            ],
            'ar' => [
                'title' => 'قصة صحراء',
                'description' => 'بدأت صحراء بقناعة بسيطة: العلامات التجارية تستحق أكثر من محتوى مبعثر ومرئيات قصيرة الأمد.',
                'content' => 'نساعد الشركات على تقديم نفسها بجودة ووضوح واتساق أكبر — بجمع إنتاج المحتوى والتوجيه البصري والهوية وإدارة وسائل التواصل.',
            ],
        ]);

        $think = $this->section($page, SectionType::HowWeThink, 2, [
            'en' => [
                'title' => 'How We Think',
                'description' => 'We believe strong digital presence starts with clarity, consistency, and brand-aligned execution — not random content or short-term visuals.',
            ],
            'fa' => [
                'title' => 'چگونه فکر می‌کنیم',
                'description' => 'باور داریم حضور دیجیتال قوی با شفافیت، ثبات و اجرای هم‌راستا با برند آغاز می‌شود — نه محتوای تصادفی.',
            ],
            'ar' => [
                'title' => 'كيف نفكر',
                'description' => 'نؤمن أن الحضور الرقمي القوي يبدأ بالوضوح والاتساق والتنفيذ المتوائم مع العلامة — لا بمحتوى عشوائي.',
            ],
        ]);

        $this->items($think, [
            [
                'en' => ['title' => 'Quality Before Quantity', 'description' => 'Intentional work over endless output'],
                'fa' => ['title' => 'کیفیت پیش از کمیت', 'description' => 'کار هدفمند به‌جای خروجی بی‌پایان'],
                'ar' => ['title' => 'الجودة قبل الكمية', 'description' => 'عمل مقصود بدل إنتاج لا ينتهي'],
            ],
            [
                'en' => ['title' => 'Brand Alignment Before Decoration', 'description' => 'Every visual should serve the brand'],
                'fa' => ['title' => 'هم‌راستایی با برند پیش از تزئین', 'description' => 'هر عنصر بصری باید در خدمت برند باشد'],
                'ar' => ['title' => 'التوافق مع العلامة قبل الزخرفة', 'description' => 'كل عنصر بصري يجب أن يخدم العلامة'],
            ],
            [
                'en' => ['title' => 'Consistency Before Noise', 'description' => 'Structure creates stronger presence'],
                'fa' => ['title' => 'ثبات پیش از هیاهو', 'description' => 'ساختار، حضور قوی‌تری می‌سازد'],
                'ar' => ['title' => 'الاتساق قبل الضجيج', 'description' => 'البنية تصنع حضوراً أقوى'],
            ],
            [
                'en' => ['title' => 'Growth Before Trends', 'description' => 'Long-term value over short-term attention'],
                'fa' => ['title' => 'رشد پیش از ترندها', 'description' => 'ارزش بلندمدت به‌جای توجه کوتاه‌مدت'],
                'ar' => ['title' => 'النمو قبل الرائج', 'description' => 'قيمة طويلة الأمد بدل انتباه عابر'],
            ],
        ]);

        $this->section($page, SectionType::Team, 3, [
            'en' => [
                'title' => 'Small Team, Big Standards',
                'description' => 'A focused team building stronger digital presence through strategy, design, content, and execution.',
            ],
            'fa' => [
                'title' => 'تیمی کوچک، استانداردهایی بزرگ',
                'description' => 'تیمی متمرکز که با استراتژی، طراحی، محتوا و اجرا حضور دیجیتال قوی‌تری می‌سازد.',
            ],
            'ar' => [
                'title' => 'فريق صغير، معايير كبيرة',
                'description' => 'فريق مركّز يبني حضوراً رقمياً أقوى عبر الاستراتيجية والتصميم والمحتوى والتنفيذ.',
            ],
        ]);

        $this->finalCta($page, 4);
    }

    /**
     * Work listing header — Figma 1362:7198.
     */
    private function work(): void
    {
        $page = $this->page('work', [
            'en' => [
                'title' => 'Where Strategy Becomes Visible',
                'subtitle' => 'Our Projects',
                'description' => 'A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction.',
            ],
            'fa' => [
                'title' => 'جایی که استراتژی دیده می‌شود',
                'subtitle' => 'پروژه‌های ما',
                'description' => 'مجموعه‌ای از پروژه‌های برند، محتوا و طراحی بازاریابی که به کسب‌وکارها کمک می‌کند شفاف ارتباط بگیرند و هدفمند رشد کنند.',
            ],
            'ar' => [
                'title' => 'حيث تصبح الاستراتيجية مرئية',
                'subtitle' => 'مشاريعنا',
                'description' => 'مجموعة من مشاريع الهوية والمحتوى وتصميم التسويق التي تساعد الشركات على التواصل بوضوح والنمو باتجاه.',
            ],
        ]);

        $page->sections()->delete();
        $this->finalCta($page, 0);
    }

    /**
     * Services header — Figma 1323:7189.
     */
    private function services(): void
    {
        $page = $this->page('services', [
            'en' => [
                'title' => 'We build systems, not just services',
                'subtitle' => 'Services',
                'description' => 'Four core services designed to bring clarity, structure, and long-term direction to your brand.',
            ],
            'fa' => [
                'title' => 'ما سیستم می‌سازیم، نه صرفاً خدمات',
                'subtitle' => 'خدمات',
                'description' => 'چهار خدمت اصلی برای ایجاد شفافیت، ساختار و مسیر بلندمدت برای برند شما.',
            ],
            'ar' => [
                'title' => 'نبني أنظمة لا مجرد خدمات',
                'subtitle' => 'الخدمات',
                'description' => 'أربع خدمات أساسية مصممة لمنح علامتك وضوحاً وبنية واتجاهاً طويل الأمد.',
            ],
        ]);

        $page->sections()->delete();
        $this->finalCta($page, 0);
    }

    /**
     * Insights header — Figma 1353:7935.
     */
    private function insights(): void
    {
        $page = $this->page('insights', [
            'en' => [
                'title' => 'Insights for Brands Ready to Grow',
                'subtitle' => 'Insights',
                'description' => 'Explore practical ideas on branding, content, social media, and marketing direction created to help businesses think clearer and grow stronger.',
            ],
            'fa' => [
                'title' => 'بینش برای برندهایی که آماده رشدند',
                'subtitle' => 'بینش',
                'description' => 'ایده‌های کاربردی درباره برندینگ، محتوا، شبکه‌های اجتماعی و جهت‌گیری بازاریابی برای شفاف‌تر اندیشیدن و قوی‌تر رشد کردن.',
            ],
            'ar' => [
                'title' => 'رؤى للعلامات التجارية المستعدة للنمو',
                'subtitle' => 'رؤى',
                'description' => 'أفكار عملية حول الهوية والمحتوى ووسائل التواصل واتجاه التسويق تساعد الشركات على التفكير بوضوح والنمو بقوة.',
            ],
        ]);

        $page->sections()->delete();
        $this->finalCta($page, 0);
    }

    /**
     * Contact — Figma 1363:8934.
     */
    private function contact(): void
    {
        $page = $this->page('contact', [
            'en' => [
                'title' => "Let's Understand Your Brand First",
                'subtitle' => 'Contact us',
                'description' => "Tell us what you need, and we'll help you find the right direction for your brand.",
            ],
            'fa' => [
                'title' => 'ابتدا برند شما را بشناسیم',
                'subtitle' => 'تماس با ما',
                'description' => 'به ما بگویید به چه نیاز دارید تا مسیر درست برند شما را پیدا کنیم.',
            ],
            'ar' => [
                'title' => 'لنفهم علامتك التجارية أولاً',
                'subtitle' => 'اتصل بنا',
                'description' => 'أخبرنا بما تحتاجه وسنساعدك في إيجاد الاتجاه الصحيح لعلامتك.',
            ],
        ]);

        $page->sections()->delete();
    }

    /**
     * Legal pages — Figma 1031:2101 and 1309:4891.
     */
    private function legal(): void
    {
        $this->page('privacy-policy', [
            'en' => [
                'title' => 'Privacy Policy',
                'content' => '<p>Sahra collects and uses information you share with us — such as your name, brand, phone number, and message — solely to understand your business needs and respond to your enquiry. We do not sell or share your personal information with third parties for marketing purposes.</p><p>Information submitted through our contact forms is stored securely and used only by our team to follow up on your request. You may ask us at any time to review, update, or delete the information we hold about you by reaching out through our contact details.</p><p>We may use cookies and similar technologies to understand how visitors use our website and to improve our services. You can control cookie preferences through your browser settings.</p><p>This policy may be updated from time to time to reflect changes in our practices. Continued use of our website after changes indicates your acceptance of the updated policy.</p>',
            ],
            'fa' => [
                'title' => 'حریم خصوصی',
                'content' => '<p>صحرا اطلاعاتی را که با ما به اشتراک می‌گذارید — مانند نام، برند، شماره تماس و پیام شما — تنها برای درک نیازهای کسب‌وکارتان و پاسخ به درخواستتان جمع‌آوری و استفاده می‌کند. ما اطلاعات شخصی شما را برای مقاصد بازاریابی به اشخاص ثالث نمی‌فروشیم و به اشتراک نمی‌گذاریم.</p><p>اطلاعات ارسالی از طریق فرم‌های تماس به‌صورت امن ذخیره می‌شود و تنها توسط تیم ما برای پیگیری درخواست شما استفاده می‌گردد. شما می‌توانید در هر زمان از طریق اطلاعات تماس ما، بازبینی، به‌روزرسانی یا حذف اطلاعات خود را درخواست کنید.</p><p>ممکن است از کوکی‌ها و فناوری‌های مشابه برای درک نحوه استفاده بازدیدکنندگان از وب‌سایت و بهبود خدمات استفاده کنیم. تنظیمات کوکی را می‌توانید از طریق مرورگر خود کنترل کنید.</p><p>این سیاست ممکن است هر از گاهی به‌روزرسانی شود. ادامه استفاده از وب‌سایت پس از تغییرات به معنای پذیرش سیاست به‌روزشده است.</p>',
            ],
            'ar' => [
                'title' => 'سياسة الخصوصية',
                'content' => '<p>تجمع صحراء المعلومات التي تشاركها معنا — مثل اسمك وعلامتك ورقم هاتفك ورسالتك — لغرض فهم احتياجات عملك والرد على استفسارك فقط. نحن لا نبيع معلوماتك الشخصية أو نشاركها مع أطراف ثالثة لأغراض تسويقية.</p><p>تُحفظ المعلومات المرسلة عبر نماذج الاتصال بشكل آمن ويستخدمها فريقنا فقط لمتابعة طلبك. يمكنك في أي وقت أن تطلب مراجعة أو تحديث أو حذف المعلومات التي نحتفظ بها عنك عبر بيانات الاتصال الخاصة بنا.</p><p>قد نستخدم ملفات تعريف الارتباط وتقنيات مشابهة لفهم كيفية استخدام الزوار لموقعنا وتحسين خدماتنا. يمكنك التحكم في تفضيلات الكوكيز من إعدادات متصفحك.</p><p>قد تُحدَّث هذه السياسة من حين لآخر. استمرارك في استخدام الموقع بعد التغييرات يعني قبولك للسياسة المحدثة.</p>',
            ],
        ]);

        $this->page('terms', [
            'en' => [
                'title' => 'Terms & Conditions',
                'content' => '<p>By using the Sahra website and submitting any form, you agree to these terms. All content on this site, including branding, visuals, and copy, is the property of Sahra and may not be reproduced without permission.</p><p>Services described on this site are subject to a separate agreement between Sahra and the client, outlining scope, timeline, and deliverables. Results referenced in our case studies reflect past project outcomes and are not a guarantee of future performance.</p><p>Sahra reserves the right to update these terms at any time. Continued use of our services after changes constitutes acceptance of the updated terms.</p>',
            ],
            'fa' => [
                'title' => 'شرایط و قوانین',
                'content' => '<p>با استفاده از وب‌سایت صحرا و ارسال هر فرم، شما این شرایط را می‌پذیرید. تمام محتوای این سایت، شامل برندینگ، تصاویر و متن، متعلق به صحرا است و بدون اجازه قابل بازتولید نیست.</p><p>خدمات توصیف‌شده در این سایت تابع قرارداد جداگانه‌ای میان صحرا و مشتری است که دامنه، زمان‌بندی و تحویل‌شدنی‌ها را مشخص می‌کند. نتایج ذکرشده در نمونه‌کارها بازتاب دستاوردهای گذشته است و تضمینی برای عملکرد آینده نیست.</p><p>صحرا حق به‌روزرسانی این شرایط را در هر زمان محفوظ می‌دارد. ادامه استفاده از خدمات پس از تغییرات به معنای پذیرش شرایط به‌روزشده است.</p>',
            ],
            'ar' => [
                'title' => 'الشروط والأحكام',
                'content' => '<p>باستخدامك موقع صحراء وإرسال أي نموذج، فإنك توافق على هذه الشروط. جميع المحتويات على هذا الموقع، بما فيها الهوية والمرئيات والنصوص، ملك لصحراء ولا يجوز إعادة إنتاجها دون إذن.</p><p>الخدمات الموصوفة على هذا الموقع تخضع لاتفاقية منفصلة بين صحراء والعميل تحدد النطاق والجدول الزمني والمخرجات. النتائج المذكورة في دراسات الحالة تعكس نتائج مشاريع سابقة ولا تشكل ضماناً للأداء المستقبلي.</p><p>تحتفظ صحراء بحق تحديث هذه الشروط في أي وقت. استمرارك في استخدام خدماتنا بعد التغييرات يعني قبولك للشروط المحدثة.</p>',
            ],
        ]);
    }

    /* ------------------------------------------------------------ helpers */

    /**
     * @param  array<string, array<string, mixed>>  $translations
     */
    private function page(string $key, array $translations): Page
    {
        $page = Page::updateOrCreate(
            ['key' => $key],
            [
                'status' => PublicationStatus::Published,
                'published_at' => now(),
            ],
        );

        $page->setTranslations($translations);

        return $page;
    }

    /**
     * @param  array<string, array<string, mixed>>  $translations
     */
    private function section(
        Page $page,
        SectionType $type,
        int $order,
        array $translations,
        bool $visible = true,
    ): PageSection {
        $section = $page->sections()->create([
            'type' => $type,
            'sort_order' => $order,
            'is_visible' => $visible,
        ]);

        $section->setTranslations($translations);

        return $section;
    }

    /**
     * @param  array<int, array<string, array<string, mixed>>>  $items
     */
    private function items(PageSection $section, array $items): void
    {
        foreach ($items as $index => $translations) {
            $item = $section->items()->create([
                'sort_order' => $index,
                'is_visible' => true,
            ]);

            $item->setTranslations($translations);
        }
    }

    /**
     * Final CTA card — Figma 1419:9333, reused on six pages.
     */
    private function finalCta(Page $page, int $order): void
    {
        $this->section($page, SectionType::FinalCta, $order, [
            'en' => [
                'eyebrow' => 'Start with clarity',
                'title' => 'Ready to build your brand with direction?',
                'description' => "Share your goals with Sahra, and let's define the right next step for your brand.",
                'primary_cta_label' => 'Start a Conversation',
                'primary_cta_url' => '/contact',
                'subtitle' => 'Branding · Content Production · Social Media Support · Marketing Design',
            ],
            'fa' => [
                'eyebrow' => 'با شفافیت آغاز کنید',
                'title' => 'آماده‌اید برندتان را با جهت بسازید؟',
                'description' => 'اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',
                'primary_cta_label' => 'شروع گفتگو',
                'primary_cta_url' => '/contact',
                'subtitle' => 'برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی',
            ],
            'ar' => [
                'eyebrow' => 'ابدأ بالوضوح',
                'title' => 'هل أنت مستعد لبناء علامتك باتجاه واضح؟',
                'description' => 'شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',
                'primary_cta_label' => 'ابدأ محادثة',
                'primary_cta_url' => '/contact',
                'subtitle' => 'الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق',
            ],
        ]);
    }
}
