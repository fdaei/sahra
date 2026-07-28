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
                'description' => 'for brands ready to grow',
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
                'description' => 'برای برندهای آماده رشد',
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
                'description' => 'للعلامات المستعدة للنمو',
            ],
        ]);

        // KPI strip — 1419:9318
        $kpi = $this->section($page, SectionType::Kpi, 1, [
            'en' => ['title' => 'Results that compound'],
            'fa' => ['title' => 'نتایجی که انباشته می‌شوند'],
            'ar' => ['title' => 'نتائج تتراكم'],
        ]);

        // Card copy is the literal text of 1419:9319 / 9320 / 9321 — value
        // (Poppins Medium 32), gold label (Medium 18), grey note (Regular 14).
        $this->items($kpi, [
            [
                'en' => [
                    'value' => '+70K',
                    'title' => 'Audience Growth',
                    'description' => 'Followers gained from one reel',
                ],
                'fa' => [
                    'value' => '+۷۰ هزار',
                    'title' => 'رشد مخاطب',
                    'description' => 'دنبال‌کننده به‌دست‌آمده از یک ریلز',
                ],
                'ar' => [
                    'value' => '+70K',
                    'title' => 'نمو الجمهور',
                    'description' => 'متابعون من مقطع واحد',
                ],
            ],
            [
                'en' => [
                    'value' => '+40%',
                    'title' => 'Engagement Lift',
                    'description' => 'Average growth after strategy refresh',
                ],
                'fa' => [
                    'value' => '+۴۰٪',
                    'title' => 'افزایش تعامل',
                    'description' => 'میانگین رشد پس از بازنگری استراتژی',
                ],
                'ar' => [
                    'value' => '+40%',
                    'title' => 'ارتفاع التفاعل',
                    'description' => 'متوسط النمو بعد تحديث الاستراتيجية',
                ],
            ],
            [
                'en' => [
                    'value' => '+90%',
                    'title' => 'Client Retention',
                    'description' => 'Across monthly marketing plans',
                ],
                'fa' => [
                    'value' => '+۹۰٪',
                    'title' => 'حفظ مشتری',
                    'description' => 'در طرح‌های ماهانه بازاریابی',
                ],
                'ar' => [
                    'value' => '+90%',
                    'title' => 'الاحتفاظ بالعملاء',
                    'description' => 'ضمن خطط التسويق الشهرية',
                ],
            ],
        ]);

        // Trust proof — 1419:9205. Figma sets the heading as three runs:
        // "Trusted by " (22 / black-600) + "+50" (28 / black-900) + " brands".
        // Stored as three fields so the emphasis survives translation.
        $this->section($page, SectionType::TrustProof, 2, [
            'en' => [
                'title' => 'Trusted by',
                'content' => '+50',
                'subtitle' => 'brands',
            ],
            'fa' => [
                'title' => 'مورد اعتماد',
                'content' => '+۵۰',
                'subtitle' => 'برند',
            ],
            'ar' => [
                'title' => 'موضع ثقة',
                'content' => '+50',
                'subtitle' => 'علامة تجارية',
            ],
        ]);

        // Services cloud — 1419:9279
        $this->section($page, SectionType::ServicesCloud, 3, [
            'en' => [
                'eyebrow' => 'Our Services',
                'title' => 'A Connected System for Brand Growth',
                'description' => 'From strategy and identity to content and campaigns, Sahra brings every part of your marketing into one clear direction',
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
                'title' => 'Is your content really directed or just consistent?',
                'description' => 'Get the Content Direction Checklist and evaluate your brand system.',
                'primary_cta_label' => 'Get checklist',
                'primary_cta_url' => '/contact',
            ],
            'fa' => [
                'title' => 'آیا محتوای شما واقعاً جهت‌مند است یا فقط منظم؟',
                'description' => 'چک‌لیست جهت‌گیری محتوا را دریافت و سیستم برند خود را ارزیابی کنید.',
                'primary_cta_label' => 'دریافت چک‌لیست',
                'primary_cta_url' => '/contact',
            ],
            'ar' => [
                'title' => 'هل محتواك موجّه فعلاً أم أنه منتظم فقط؟',
                'description' => 'احصل على قائمة توجيه المحتوى وقيّم نظام علامتك التجارية.',
                'primary_cta_label' => 'احصل على القائمة',
                'primary_cta_url' => '/contact',
            ],
        ]);

        // Projects showcase — 1419:9216
        $this->section($page, SectionType::ProjectsShowcase, 5, [
            'en' => [
                'eyebrow' => 'Our Projects',
                'title' => 'Where Strategy Becomes Visible',
                'subtitle' => 'A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction',
                'primary_cta_label' => 'View all work',
                'primary_cta_url' => '/work',
            ],
            'fa' => [
                'eyebrow' => 'پروژه‌های ما',
                'title' => 'جایی که استراتژی دیده می‌شود',
                'subtitle' => 'مجموعه‌ای از پروژه‌های برند، محتوا و طراحی بازاریابی برای کمک به کسب‌وکارها تا شفاف‌تر ارتباط برقرار کنند و هدفمند رشد کنند.',
                'primary_cta_label' => 'مشاهده همه نمونه‌کارها',
                'primary_cta_url' => '/work',
            ],
            'ar' => [
                'eyebrow' => 'مشاريعنا',
                'title' => 'حيث تصبح الاستراتيجية مرئية',
                'subtitle' => 'مجموعة من مشاريع العلامة والمحتوى والتصميم التسويقي لمساعدة الشركات على التواصل بوضوح والنمو باتجاه هادف.',
                'primary_cta_label' => 'شاهد كل الأعمال',
                'primary_cta_url' => '/work',
            ],
        ]);

        // Process — 1419:9302
        $process = $this->section($page, SectionType::Process, 6, [
            'en' => [
                'eyebrow' => 'Our Process',
                'title' => 'A Clear Path to Brand Growth',
                'subtitle' => 'Our process keeps every project clear, structured, and aligned with your brand’s real needs.',
            ],
            'fa' => [
                'eyebrow' => 'فرایند ما',
                'title' => 'مسیری روشن برای رشد برند',
                'subtitle' => 'فرایند ما هر پروژه را شفاف، ساختاریافته و هم‌راستا با نیازهای واقعی برند شما نگه می‌دارد.',
            ],
            'ar' => [
                'eyebrow' => 'عمليتنا',
                'title' => 'مسار واضح لنمو العلامة',
                'subtitle' => 'تحافظ عمليتنا على وضوح كل مشروع وتنظيمه وتوافقه مع الاحتياجات الحقيقية لعلامتك.',
            ],
        ]);

        $this->items($process, [
            [
                '_icon' => 'discovery',
                'en' => ['value' => '01', 'title' => 'Discovery & Brand Review', 'description' => 'Deep analysis of your brand, audience, and market position'],
                'fa' => ['value' => '۰۱', 'title' => 'کشف و بررسی برند', 'description' => 'تحلیل عمیق برند، مخاطب و جایگاه شما در بازار'],
                'ar' => ['value' => '01', 'title' => 'اكتشاف ومراجعة العلامة', 'description' => 'تحليل عميق لعلامتك وجمهورك وموقعك في السوق'],
            ],
            [
                '_icon' => 'strategy',
                'en' => ['value' => '02', 'title' => 'Strategy & Content Plan', 'description' => 'Custom content plans focused on consistency and growth'],
                'fa' => ['value' => '۰۲', 'title' => 'استراتژی و برنامه محتوا', 'description' => 'برنامه‌های محتوایی اختصاصی با تمرکز بر ثبات و رشد'],
                'ar' => ['value' => '02', 'title' => 'الاستراتيجية وخطة المحتوى', 'description' => 'خطط محتوى مخصصة تركز على الاتساق والنمو'],
            ],
            [
                '_icon' => 'production',
                'en' => ['value' => '03', 'title' => 'Design & Production', 'description' => 'High-quality visuals aligned with your brand'],
                'fa' => ['value' => '۰۳', 'title' => 'طراحی و تولید', 'description' => 'تصاویر باکیفیت و هم‌راستا با برند شما'],
                'ar' => ['value' => '03', 'title' => 'التصميم والإنتاج', 'description' => 'مرئيات عالية الجودة ومتوافقة مع علامتك'],
            ],
            [
                '_icon' => 'approval',
                'en' => ['value' => '04', 'title' => 'Review & Approval', 'description' => 'Review and refine all content before it goes live'],
                'fa' => ['value' => '۰۴', 'title' => 'بازبینی و تأیید', 'description' => 'بازبینی و اصلاح تمام محتوا پیش از انتشار'],
                'ar' => ['value' => '04', 'title' => 'المراجعة والموافقة', 'description' => 'مراجعة وتحسين كل المحتوى قبل نشره'],
            ],
            [
                '_icon' => 'publishing',
                'en' => ['value' => '05', 'title' => 'Publishing & Management', 'description' => 'Professional scheduling and active platform management'],
                'fa' => ['value' => '۰۵', 'title' => 'انتشار و مدیریت', 'description' => 'زمان‌بندی حرفه‌ای و مدیریت فعال پلتفرم‌ها'],
                'ar' => ['value' => '05', 'title' => 'النشر والإدارة', 'description' => 'جدولة احترافية وإدارة فعالة للمنصات'],
            ],
            [
                '_icon' => 'optimization',
                'en' => ['value' => '06', 'title' => 'Reporting & Optimization', 'description' => 'Performance tracking and data-driven optimization'],
                'fa' => ['value' => '۰۶', 'title' => 'گزارش‌دهی و بهینه‌سازی', 'description' => 'پایش عملکرد و بهینه‌سازی داده‌محور'],
                'ar' => ['value' => '06', 'title' => 'التقارير والتحسين', 'description' => 'تتبع الأداء والتحسين القائم على البيانات'],
            ],
        ]);

        // Packages — 1419:9323
        $packages = $this->section($page, SectionType::Packages, 7, [
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
        ]);

        $this->items($packages, [
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
        ]);

        // Why us — 1419:9230
        $why = $this->section($page, SectionType::WhyUs, 8, [
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
                'title' => 'لماذا تختار العلامات التجارية صحراء',
                'subtitle' => 'لأن كل قرار إبداعي يُبنى حول وضوح العلامة واتساقها ونموها.',
            ],
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
                'subtitle' => 'At Sahra Marketing, we respect your privacy and are committed to protecting the personal information you share with us through our website',
                'content' => $this->privacyBody('en'),
            ],
            'fa' => [
                'title' => 'حریم خصوصی',
                'subtitle' => 'در صحرا مارکتینگ به حریم خصوصی شما احترام می‌گذاریم و متعهد به حفاظت از اطلاعات شخصی‌ای هستیم که از طریق وب‌سایت با ما به اشتراک می‌گذارید.',
                'content' => $this->privacyBody('fa'),
            ],
            'ar' => [
                'title' => 'سياسة الخصوصية',
                'subtitle' => 'في صحراء ماركتينغ نحترم خصوصيتك ونلتزم بحماية المعلومات الشخصية التي تشاركها معنا عبر موقعنا.',
                'content' => $this->privacyBody('ar'),
            ],
        ]);

        $this->page('terms', [
            'en' => [
                'title' => 'Terms & Conditions',
                'subtitle' => 'At Sahra Marketing, we provide clear guidelines for using our website and services to ensure a reliable and respectful experience for all users.',
                'content' => $this->termsBody('en'),
            ],
            'fa' => [
                'title' => 'شرایط و قوانین',
                'subtitle' => 'در صحرا مارکتینگ دستورالعمل‌های شفافی برای استفاده از وب‌سایت و خدمات ارائه می‌کنیم تا تجربه‌ای قابل‌اعتماد و محترمانه برای همه کاربران فراهم شود.',
                'content' => $this->termsBody('fa'),
            ],
            'ar' => [
                'title' => 'الشروط والأحكام',
                'subtitle' => 'في صحراء ماركتينغ نقدم إرشادات واضحة لاستخدام موقعنا وخدماتنا لضمان تجربة موثوقة ومحترمة لجميع المستخدمين.',
                'content' => $this->termsBody('ar'),
            ],
        ]);
    }


    /**
     * Privacy Policy body — the literal section text of Figma 1031:2101.
     * Kept as a helper so the three locales stay structurally identical.
     */
    private function privacyBody(string $locale): string
    {
        $sections = [
            'en' => [
                ['Information We Collect', [
                    'When you contact us, submit a form, download a file, or request information about our services, we may collect basic information such as your name, email address, phone number, company name, and any message or project details you choose to share with us.',
                    'We may also collect limited technical information, such as website usage data, browser type, device information, and general analytics data to help us improve our website experience.',
                ]],
                ['How We Use Your Information', [
                    'We use the information you provide to:',
                    ['Respond to your inquiries', 'Understand your business needs', 'Share information about our services', 'Prepare proposals or follow-up communications', 'Improve our website and user experience', 'Measure the performance of our marketing activities'],
                    'We do not sell your personal information.',
                ]],
                ['Cookies &amp; Analytics', [
                    'Our website may use cookies and analytics tools to understand how visitors use the site and to improve performance, content, and marketing efforts. You can control or disable cookies through your browser settings.',
                ]],
                ['Sharing Your Information', [
                    'We may share your information only when necessary with trusted service providers who help us operate our website, manage communications, analyze website performance, or deliver our services.',
                    'We may also disclose information if required by law or to protect our legal rights.',
                ]],
                ['Data Security', [
                    'We take reasonable steps to protect your personal information from unauthorized access, loss, misuse, or disclosure. However, no online platform can guarantee complete security.',
                ]],
                ['Data Retention', [
                    'We keep your information only for as long as necessary to respond to your request, manage our business relationship, provide services, or meet legal and operational requirements.',
                ]],
                ['Your Rights', [
                    'You may contact us to request access to your personal information, ask for corrections, or request that your information be deleted from our records, where applicable.',
                ]],
                ['Contact Us', [
                    'If you have any questions about this Privacy Policy or how we handle your information, please contact us at:',
                    ['__address__', 'Sahra Marketing', 'Muscat, Oman', 'Email: Sahramarketing@gmail.com'],
                ]],
            ],
            'fa' => [
                ['اطلاعاتی که جمع‌آوری می‌کنیم', [
                    'وقتی با ما تماس می‌گیرید، فرمی ارسال می‌کنید، فایلی دانلود می‌کنید یا درباره خدمات ما اطلاعات می‌خواهید، ممکن است اطلاعات پایه‌ای مانند نام، نشانی ایمیل، شماره تماس، نام شرکت و هر پیام یا جزئیات پروژه‌ای که انتخاب می‌کنید با ما به اشتراک بگذارید را جمع‌آوری کنیم.',
                    'همچنین ممکن است اطلاعات فنی محدودی مانند داده‌های استفاده از وب‌سایت، نوع مرورگر، اطلاعات دستگاه و داده‌های تحلیلی عمومی را برای بهبود تجربه وب‌سایت جمع‌آوری کنیم.',
                ]],
                ['چگونه از اطلاعات شما استفاده می‌کنیم', [
                    'از اطلاعاتی که ارائه می‌دهید برای این موارد استفاده می‌کنیم:',
                    ['پاسخ به پرسش‌های شما', 'درک نیازهای کسب‌وکارتان', 'ارائه اطلاعات درباره خدمات ما', 'تهیه پیشنهاد یا پیگیری‌های بعدی', 'بهبود وب‌سایت و تجربه کاربری', 'سنجش عملکرد فعالیت‌های بازاریابی ما'],
                    'ما اطلاعات شخصی شما را نمی‌فروشیم.',
                ]],
                ['کوکی‌ها و تحلیل‌ها', [
                    'وب‌سایت ما ممکن است از کوکی‌ها و ابزارهای تحلیلی برای درک نحوه استفاده بازدیدکنندگان از سایت و بهبود عملکرد، محتوا و تلاش‌های بازاریابی استفاده کند. می‌توانید کوکی‌ها را از تنظیمات مرورگر خود کنترل یا غیرفعال کنید.',
                ]],
                ['اشتراک‌گذاری اطلاعات شما', [
                    'اطلاعات شما را تنها در صورت لزوم با ارائه‌دهندگان خدمات مورد اعتمادی که در راه‌اندازی وب‌سایت، مدیریت ارتباطات، تحلیل عملکرد یا ارائه خدمات به ما کمک می‌کنند به اشتراک می‌گذاریم.',
                    'همچنین ممکن است در صورت الزام قانونی یا برای حفاظت از حقوق قانونی خود اطلاعات را افشا کنیم.',
                ]],
                ['امنیت داده‌ها', [
                    'ما اقدامات معقولی برای محافظت از اطلاعات شخصی شما در برابر دسترسی غیرمجاز، از دست رفتن، سوءاستفاده یا افشا انجام می‌دهیم. با این حال هیچ پلتفرم آنلاینی نمی‌تواند امنیت کامل را تضمین کند.',
                ]],
                ['نگهداری داده‌ها', [
                    'اطلاعات شما را تنها تا زمانی که برای پاسخ به درخواستتان، مدیریت رابطه کاری، ارائه خدمات یا رعایت الزامات قانونی و عملیاتی لازم است نگهداری می‌کنیم.',
                ]],
                ['حقوق شما', [
                    'می‌توانید برای درخواست دسترسی به اطلاعات شخصی، اصلاح آن یا حذف اطلاعاتتان از سوابق ما — در مواردی که قابل اعمال باشد — با ما تماس بگیرید.',
                ]],
                ['تماس با ما', [
                    'اگر درباره این سیاست حریم خصوصی یا نحوه مدیریت اطلاعاتتان پرسشی دارید، با ما تماس بگیرید:',
                    ['__address__', 'صحرا مارکتینگ', 'مسقط، عمان', 'ایمیل: Sahramarketing@gmail.com'],
                ]],
            ],
            'ar' => [
                ['المعلومات التي نجمعها', [
                    'عند التواصل معنا أو إرسال نموذج أو تنزيل ملف أو طلب معلومات عن خدماتنا، قد نجمع معلومات أساسية مثل اسمك وبريدك الإلكتروني ورقم هاتفك واسم شركتك وأي رسالة أو تفاصيل مشروع تختار مشاركتها معنا.',
                    'وقد نجمع أيضاً معلومات تقنية محدودة، مثل بيانات استخدام الموقع ونوع المتصفح ومعلومات الجهاز وبيانات التحليلات العامة لمساعدتنا في تحسين تجربة الموقع.',
                ]],
                ['كيف نستخدم معلوماتك', [
                    'نستخدم المعلومات التي تقدمها من أجل:',
                    ['الرد على استفساراتك', 'فهم احتياجات عملك', 'مشاركة معلومات عن خدماتنا', 'إعداد العروض أو المتابعات', 'تحسين موقعنا وتجربة المستخدم', 'قياس أداء أنشطتنا التسويقية'],
                    'نحن لا نبيع معلوماتك الشخصية.',
                ]],
                ['ملفات الارتباط والتحليلات', [
                    'قد يستخدم موقعنا ملفات الارتباط وأدوات التحليل لفهم كيفية استخدام الزوار للموقع ولتحسين الأداء والمحتوى وجهود التسويق. يمكنك التحكم في ملفات الارتباط أو تعطيلها من إعدادات متصفحك.',
                ]],
                ['مشاركة معلوماتك', [
                    'قد نشارك معلوماتك عند الضرورة فقط مع مزودي خدمات موثوقين يساعدوننا في تشغيل موقعنا أو إدارة الاتصالات أو تحليل أداء الموقع أو تقديم خدماتنا.',
                    'وقد نفصح عن المعلومات إذا اقتضى القانون ذلك أو لحماية حقوقنا القانونية.',
                ]],
                ['أمن البيانات', [
                    'نتخذ خطوات معقولة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو الفقدان أو سوء الاستخدام أو الإفصاح. ومع ذلك، لا يمكن لأي منصة إلكترونية ضمان الأمان الكامل.',
                ]],
                ['الاحتفاظ بالبيانات', [
                    'نحتفظ بمعلوماتك فقط للمدة اللازمة للرد على طلبك وإدارة علاقتنا التجارية وتقديم الخدمات أو تلبية المتطلبات القانونية والتشغيلية.',
                ]],
                ['حقوقك', [
                    'يمكنك التواصل معنا لطلب الوصول إلى معلوماتك الشخصية أو طلب تصحيحها أو حذفها من سجلاتنا، حيثما ينطبق ذلك.',
                ]],
                ['اتصل بنا', [
                    'إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه أو كيفية تعاملنا مع معلوماتك، يرجى التواصل معنا على:',
                    ['__address__', 'صحراء ماركتينغ', 'مسقط، عُمان', 'البريد الإلكتروني: Sahramarketing@gmail.com'],
                ]],
            ],
        ];

        return $this->renderSections($sections[$locale]);
    }

    /**
     * Terms & Conditions body — the literal section text of Figma 1072:2618.
     */
    private function termsBody(string $locale): string
    {
        $sections = [
            'en' => [
                ['Use of Website', ['By accessing this website, you agree to use it only for lawful purposes and in a way that does not harm the experience, content, or functionality of the platform.']],
                ['Services', ['Sahra provides branding, marketing design, content production, and social media support services. All services are delivered based on agreed project scope and timelines defined during collaboration.']],
                ['Intellectual Property', ['All content, designs, visuals, and materials created by Sahra remain the intellectual property of Sahra unless otherwise agreed in writing. Unauthorized use or reproduction is not allowed.']],
                ['Client Responsibilities', ['Clients are responsible for providing accurate information, timely feedback, and required materials needed for project execution. Delays in communication may affect delivery timelines.']],
                ['Payments', ['All project costs, pricing structures, and payment terms are agreed upon before starting any work. Work may be paused in case of delayed payments.']],
                ['Limitation of Liability', ['Sahra is not responsible for any indirect, incidental, or consequential damages arising from the use of this website or services.']],
                ['Changes to Terms', ['Sahra reserves the right to update these Terms &amp; Conditions at any time. Continued use of the website means acceptance of any updated terms.']],
                ['Contact Us', [
                    'For any questions regarding these terms, you can contact us at:',
                    ['__address__', 'Sahra Marketing', 'Muscat, Oman', 'Email: Sahramarketing@gmail.com'],
                ]],
            ],
            'fa' => [
                ['استفاده از وب‌سایت', ['با دسترسی به این وب‌سایت می‌پذیرید که تنها برای مقاصد قانونی و به‌گونه‌ای از آن استفاده کنید که به تجربه، محتوا یا عملکرد پلتفرم آسیب نرساند.']],
                ['خدمات', ['صحرا خدمات برندینگ، طراحی بازاریابی، تولید محتوا و پشتیبانی شبکه‌های اجتماعی ارائه می‌کند. همه خدمات بر اساس دامنه و زمان‌بندی توافق‌شده در جریان همکاری تحویل می‌شوند.']],
                ['مالکیت فکری', ['تمام محتوا، طرح‌ها، تصاویر و موادی که صحرا خلق می‌کند، مگر در صورت توافق کتبی دیگر، متعلق به صحرا باقی می‌ماند. استفاده یا بازتولید غیرمجاز مجاز نیست.']],
                ['مسئولیت‌های مشتری', ['مشتریان مسئول ارائه اطلاعات دقیق، بازخورد به‌موقع و موادی هستند که برای اجرای پروژه لازم است. تأخیر در ارتباط ممکن است بر زمان‌بندی تحویل اثر بگذارد.']],
                ['پرداخت‌ها', ['تمام هزینه‌های پروژه، ساختار قیمت‌گذاری و شرایط پرداخت پیش از آغاز کار توافق می‌شود. در صورت تأخیر در پرداخت، کار ممکن است متوقف شود.']],
                ['محدودیت مسئولیت', ['صحرا مسئول هیچ خسارت غیرمستقیم، تبعی یا اتفاقی ناشی از استفاده از این وب‌سایت یا خدمات نیست.']],
                ['تغییر شرایط', ['صحرا حق به‌روزرسانی این شرایط و قوانین را در هر زمان محفوظ می‌دارد. ادامه استفاده از وب‌سایت به معنای پذیرش شرایط به‌روزشده است.']],
                ['تماس با ما', [
                    'برای هر پرسشی درباره این شرایط می‌توانید با ما تماس بگیرید:',
                    ['__address__', 'صحرا مارکتینگ', 'مسقط، عمان', 'ایمیل: Sahramarketing@gmail.com'],
                ]],
            ],
            'ar' => [
                ['استخدام الموقع', ['بدخولك هذا الموقع، فإنك توافق على استخدامه للأغراض المشروعة فقط وبطريقة لا تضر بتجربة المنصة أو محتواها أو أدائها.']],
                ['الخدمات', ['تقدم صحراء خدمات الهوية التجارية وتصميم التسويق وإنتاج المحتوى ودعم وسائل التواصل. تُقدَّم جميع الخدمات وفق نطاق المشروع والجداول الزمنية المتفق عليها أثناء التعاون.']],
                ['الملكية الفكرية', ['يبقى كل محتوى وتصميم ومواد تنشئها صحراء ملكية فكرية لصحراء ما لم يُتفق على خلاف ذلك كتابةً. الاستخدام أو النسخ غير المصرح به غير مسموح.']],
                ['مسؤوليات العميل', ['العملاء مسؤولون عن تقديم معلومات دقيقة وملاحظات في وقتها والمواد المطلوبة لتنفيذ المشروع. قد تؤثر التأخيرات في التواصل على مواعيد التسليم.']],
                ['المدفوعات', ['يُتفق على جميع تكاليف المشروع وهياكل التسعير وشروط الدفع قبل بدء أي عمل. وقد يتوقف العمل في حال تأخر المدفوعات.']],
                ['حدود المسؤولية', ['صحراء غير مسؤولة عن أي أضرار غير مباشرة أو عرضية أو تبعية تنشأ عن استخدام هذا الموقع أو الخدمات.']],
                ['تغييرات الشروط', ['تحتفظ صحراء بحق تحديث هذه الشروط والأحكام في أي وقت. استمرار استخدام الموقع يعني قبول أي شروط محدثة.']],
                ['اتصل بنا', [
                    'لأي أسئلة بخصوص هذه الشروط، يمكنك التواصل معنا على:',
                    ['__address__', 'صحراء ماركتينغ', 'مسقط، عُمان', 'البريد الإلكتروني: Sahramarketing@gmail.com'],
                ]],
            ],
        ];

        return $this->renderSections($sections[$locale]);
    }

    /**
     * Turn the [heading, blocks] tuples above into the stored HTML. A nested
     * array is a bullet list, unless its first entry is `__address__`, which
     * marks the contact block the design renders as plain stacked lines.
     *
     * @param  array<int, array{0: string, 1: array<int, string|array<int, string>>}>  $sections
     */
    private function renderSections(array $sections): string
    {
        $html = '';

        foreach ($sections as [$heading, $blocks]) {
            $html .= '<h2>'.$heading.'</h2>';

            foreach ($blocks as $block) {
                if (! is_array($block)) {
                    $html .= '<p>'.$block.'</p>';

                    continue;
                }

                if (($block[0] ?? null) === '__address__') {
                    $lines = array_slice($block, 1);
                    $html .= '<p>'.implode('<br>', $lines).'</p>';

                    continue;
                }

                $html .= '<ul>';
                foreach ($block as $item) {
                    $html .= '<li>'.$item.'</li>';
                }
                $html .= '</ul>';
            }
        }

        return $html;
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
     * @param  array<int, array<string, mixed>>  $items
     */
    private function items(PageSection $section, array $items): void
    {
        foreach ($items as $index => $itemData) {
            $icon = $itemData['_icon'] ?? null;
            unset($itemData['_icon']);

            $item = $section->items()->create([
                'sort_order' => $index,
                'is_visible' => true,
                'icon' => $icon,
            ]);

            /** @var array<string, array<string, mixed>> $itemData */
            $item->setTranslations($itemData);
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
