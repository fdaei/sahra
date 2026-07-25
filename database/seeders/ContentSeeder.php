<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Faq;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

/**
 * Team, testimonials, FAQs and client logos.
 *
 * Team roster from Figma 908:1576; testimonial from 1419:9251.
 * Image paths point at docs/ASSET-MANIFEST.md destinations.
 */
final class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->team();
        $this->testimonials();
        $this->faqs();
        $this->clients();
    }

    private function team(): void
    {
        $members = [
            ['amin.webp', 'Amin', 'CEO', 'امین', 'مدیرعامل', 'أمين', 'الرئيس التنفيذي'],
            ['melika.webp', 'Melika', 'Brand Strategist', 'ملیکا', 'استراتژیست برند', 'مليكا', 'استراتيجية العلامة'],
            ['banin-1.webp', 'Banin', 'Graphic Designer', 'بنین', 'طراح گرافیک', 'بنين', 'مصممة جرافيك'],
            ['banin-2.webp', 'Banin', 'Graphic Designer', 'بنین', 'طراح گرافیک', 'بنين', 'مصممة جرافيك'],
            ['mohammad.webp', 'Mohammad', 'Graphic Designer', 'محمد', 'طراح گرافیک', 'محمد', 'مصمم جرافيك'],
            ['iman.webp', 'Iman', 'Videographer', 'ایمان', 'فیلم‌بردار', 'إيمان', 'مصور فيديو'],
            ['razieh.webp', 'Razieh', 'Brand Strategist', 'راضیه', 'استراتژیست برند', 'راضية', 'استراتيجية العلامة'],
            ['amir.webp', 'Amir', 'Video Creator', 'امیر', 'سازنده ویدیو', 'أمير', 'صانع فيديو'],
            ['afshin-1.webp', 'Afshin', 'Brand Strategist', 'افشین', 'استراتژیست برند', 'أفشين', 'استراتيجي العلامة'],
            ['afshin-2.webp', 'Afshin', 'Brand Strategist', 'افشین', 'استراتژیست برند', 'أفشين', 'استراتيجي العلامة'],
        ];

        foreach ($members as $index => [$photo, $enName, $enRole, $faName, $faRole, $arName, $arRole]) {
            $member = TeamMember::updateOrCreate(
                ['id' => $index + 1],
                [
                    'photo_path' => "team/{$photo}",
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            $member->setTranslations([
                'en' => ['name' => $enName, 'role' => $enRole, 'photo_alt' => "{$enName}, {$enRole} at Sahra"],
                'fa' => ['name' => $faName, 'role' => $faRole, 'photo_alt' => "{$faName}، {$faRole} در صحرا"],
                'ar' => ['name' => $arName, 'role' => $arRole, 'photo_alt' => "{$arName}، {$arRole} في صحراء"],
            ]);
        }
    }

    private function testimonials(): void
    {
        $testimonial = Testimonial::updateOrCreate(
            ['id' => 1],
            [
                'avatar_path' => 'testimonials/sara-amiri.webp',
                'sort_order' => 0,
                'is_active' => true,
            ],
        );

        $testimonial->setTranslations([
            'en' => [
                'author_name' => 'Sara Amiri',
                'author_role' => 'All Digital manager',
                'quote' => 'Sahra helped us turn our scattered marketing into a clear and structured system. For the first time, our content, campaigns, and brand messaging all feel aligned both online and in-store.',
                'avatar_alt' => 'Portrait of Sara Amiri',
            ],
            'fa' => [
                'author_name' => 'سارا امیری',
                'author_role' => 'مدیر All Digital',
                'quote' => 'صحرا به ما کمک کرد بازاریابی پراکنده‌مان را به سیستمی شفاف و ساختارمند تبدیل کنیم. برای نخستین بار محتوا، کمپین‌ها و پیام برند ما هم آنلاین و هم در فروشگاه هم‌راستا شده‌اند.',
                'avatar_alt' => 'تصویر سارا امیری',
            ],
            'ar' => [
                'author_name' => 'سارة أميري',
                'author_role' => 'مديرة All Digital',
                'quote' => 'ساعدتنا صحراء في تحويل تسويقنا المبعثر إلى نظام واضح ومنظم. لأول مرة يبدو المحتوى والحملات ورسائل العلامة متوائمة عبر الإنترنت وفي المتجر.',
                'avatar_alt' => 'صورة سارة أميري',
            ],
        ]);
    }

    private function faqs(): void
    {
        $faqs = [
            [
                'en' => ['question' => 'How long does a branding project take?', 'answer' => 'Most branding projects run six to eight weeks from discovery to final handover, depending on scope and how quickly feedback comes back.'],
                'fa' => ['question' => 'یک پروژه برندینگ چقدر طول می‌کشد؟', 'answer' => 'بیشتر پروژه‌های برندینگ از مرحله کشف تا تحویل نهایی شش تا هشت هفته زمان می‌برد؛ بسته به دامنه کار و سرعت دریافت بازخورد.'],
                'ar' => ['question' => 'كم يستغرق مشروع الهوية التجارية؟', 'answer' => 'تستغرق معظم مشاريع الهوية من ستة إلى ثمانية أسابيع من الاكتشاف حتى التسليم النهائي، حسب النطاق وسرعة وصول الملاحظات.'],
            ],
            [
                'en' => ['question' => 'Do you work with brands outside Oman?', 'answer' => 'Yes. We are based in Muscat and work with brands across the region and further afield, running projects remotely with scheduled check-ins.'],
                'fa' => ['question' => 'با برندهای خارج از عمان هم کار می‌کنید؟', 'answer' => 'بله. ما در مسقط مستقر هستیم و با برندهایی در سراسر منطقه و فراتر از آن کار می‌کنیم؛ پروژه‌ها از راه دور با جلسات منظم پیش می‌روند.'],
                'ar' => ['question' => 'هل تعملون مع علامات خارج عُمان؟', 'answer' => 'نعم. مقرنا مسقط ونعمل مع علامات في المنطقة وخارجها، وندير المشاريع عن بُعد بجلسات متابعة مجدولة.'],
            ],
            [
                'en' => ['question' => 'Can you work with our existing brand guidelines?', 'answer' => 'Absolutely. If you already have a brand book we build within it, and flag anything that is holding the brand back rather than replacing it wholesale.'],
                'fa' => ['question' => 'می‌توانید با دستورالعمل برند فعلی ما کار کنید؟', 'answer' => 'قطعاً. اگر کتاب برند دارید، درون همان چارچوب کار می‌کنیم و به‌جای جایگزینی کامل، مواردی را که مانع رشد برند است مطرح می‌کنیم.'],
                'ar' => ['question' => 'هل يمكنكم العمل ضمن دليل علامتنا الحالي؟', 'answer' => 'بالتأكيد. إن كان لديكم دليل علامة نعمل ضمنه، ونشير إلى ما يعيق العلامة بدل استبداله بالكامل.'],
            ],
            [
                'en' => ['question' => 'What do you need from us to start?', 'answer' => 'A short conversation about your goals, your audience, and what has and has not worked so far. We handle the rest of the discovery.'],
                'fa' => ['question' => 'برای شروع به چه چیزی از ما نیاز دارید؟', 'answer' => 'یک گفتگوی کوتاه درباره اهداف، مخاطب و اینکه تا امروز چه چیزی جواب داده و چه چیزی نه. بقیه مرحله کشف با ماست.'],
                'ar' => ['question' => 'ماذا تحتاجون منا للبدء؟', 'answer' => 'محادثة قصيرة عن أهدافكم وجمهوركم وما نجح وما لم ينجح حتى الآن. ونتولى نحن بقية مرحلة الاكتشاف.'],
            ],
        ];

        foreach ($faqs as $index => $translations) {
            $faq = Faq::updateOrCreate(
                ['id' => $index + 1],
                ['sort_order' => $index, 'is_active' => true],
            );

            $faq->setTranslations($translations);
        }
    }

    private function clients(): void
    {
        $clients = [
            ['pars.svg', 'Pars Clinic', 'کلینیک پارس', 'عيادة بارس'],
            ['all-digitall.svg', 'allDigitall.ir', 'allDigitall.ir', 'allDigitall.ir'],
            ['baghche.svg', 'Baghche', 'باغچه', 'باغتشه'],
            ['noora.svg', 'Noora', 'نورا', 'نورا'],
            ['vanak.svg', 'Vanak', 'ونک', 'ونك'],
            ['tavakoli.svg', 'Tavakoli', 'توکلی', 'توكلي'],
        ];

        foreach ($clients as $index => [$logo, $en, $fa, $ar]) {
            $client = Client::updateOrCreate(
                ['id' => $index + 1],
                [
                    'logo_path' => "clients/{$logo}",
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            $client->setTranslations([
                'en' => ['name' => $en, 'logo_alt' => "{$en} logo"],
                'fa' => ['name' => $fa, 'logo_alt' => "لوگوی {$fa}"],
                'ar' => ['name' => $ar, 'logo_alt' => "شعار {$ar}"],
            ]);
        }
    }
}
