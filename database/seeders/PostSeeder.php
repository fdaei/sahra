<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PublicationStatus;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Blog articles. The full article body comes from the Figma single-blog
 * frame (1352:7391); listing copy reuses its subtitle/excerpt.
 */
final class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();
        $socialCategory = PostCategory::query()
            ->withTranslations()
            ->get()
            ->first(fn (PostCategory $c): bool => $c->getTranslation('slug', 'en') === 'social-media-support');

        $growthCategory = PostCategory::query()
            ->withTranslations()
            ->get()
            ->first(fn (PostCategory $c): bool => $c->getTranslation('slug', 'en') === 'marketing-design');

        $enBody = <<<'HTML'
<h3>Most brands don't struggle with creating content, They struggle with creating direction</h3>
<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn't feel like it is actually moving forward in a meaningful way.</p>
<h3>Content without direction becomes noise</h3>
<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>
<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>
<h3>You stay busy, but your brand stays still</h3>
<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>
<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>
<h3>Without direction, your message changes every time you speak</h3>
<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>
<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>
<h3>Final Thoughts</h3>
<p>Content without direction doesn't fail because it's bad, it fails because it's incomplete. Real growth starts when content becomes part of a clear system.</p>
HTML;

        $faBody = <<<'HTML'
<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>
<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>
<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>
<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>
<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>
<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>
<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>
<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>
<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>
<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>
<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>
<h3>سخن پایانی</h3>
<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>
HTML;

        $arBody = <<<'HTML'
<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>
<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>
<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>
<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>
<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>
<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>
<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>
<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>
<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>
<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>
<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>
<h3>خواطر ختامية</h3>
<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>
HTML;

        $posts = [
            [
                'slug' => 'content-without-direction',
                'category' => $socialCategory,
                'featured' => true,
                'cover' => 'posts/brand-direction.webp',
                'en' => ['title' => 'What Happens When You Create Content Without Direction?', 'subtitle' => 'Without direction, your content loses focus and fails to drive real growth', 'excerpt' => 'Without direction, your content loses focus and fails to drive real growth.', 'content' => $enBody],
                'fa' => ['title' => 'وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟', 'subtitle' => 'بدون جهت، محتوای شما تمرکز خود را از دست می‌دهد', 'excerpt' => 'بدون جهت، محتوای شما تمرکز خود را از دست می‌دهد و رشد واقعی ایجاد نمی‌کند.', 'content' => $faBody],
                'ar' => ['title' => 'ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟', 'subtitle' => 'بلا اتجاه، يفقد محتواك تركيزه', 'excerpt' => 'بلا اتجاه، يفقد محتواك تركيزه ويفشل في دفع نمو حقيقي.', 'content' => $arBody],
            ],
            [
                'slug' => 'social-media-growth-system',
                'category' => $growthCategory,
                'featured' => false,
                'cover' => 'posts/social-growth.webp',
                'en' => ['title' => 'How to Turn Social Media Into a Growth System', 'subtitle' => 'From scattered posts to a predictable engine', 'excerpt' => 'From scattered posts and inconsistent messaging to a structured growth system that turns your social media into a predictable engine for attracting the right audience.', 'content' => $enBody],
                'fa' => ['title' => 'چگونه شبکه‌های اجتماعی را به یک سیستم رشد تبدیل کنیم', 'subtitle' => 'از پست‌های پراکنده تا موتوری قابل پیش‌بینی', 'excerpt' => 'از پست‌های پراکنده و پیام‌رسانی ناهماهنگ تا سیستمی ساختارمند که شبکه‌های اجتماعی شما را به موتوری قابل پیش‌بینی تبدیل می‌کند.', 'content' => $faBody],
                'ar' => ['title' => 'كيف تحوّل وسائل التواصل إلى نظام نمو', 'subtitle' => 'من منشورات مبعثرة إلى محرك يمكن التنبؤ به', 'excerpt' => 'من منشورات مبعثرة ورسائل غير متسقة إلى نظام نمو منظم يحول وسائل التواصل لديك إلى محرك يمكن التنبؤ به.', 'content' => $arBody],
            ],
        ];

        foreach ($posts as $index => $data) {
            $post = Post::updateOrCreate(
                ['id' => $index + 1],
                [
                    'post_category_id' => $data['category']?->id,
                    'user_id' => $author?->id,
                    'status' => PublicationStatus::Published,
                    // Figma 604:1464 dates every article "May 09, 2024".
                    'published_at' => Carbon::create(2024, 5, 9, 9, 0)->subDays($index),
                    'is_featured' => $data['featured'],
                    // Rendered from the Figma insight cards (1419:9265 /
                    // 1419:9271), so the filenames follow the artwork, not
                    // the slug.
                    'cover_path' => $data['cover'],
                    'reading_minutes' => 5,
                ],
            );

            $post->setTranslations([
                'en' => array_merge(['slug' => $data['slug']], $data['en']),
                'fa' => array_merge(['slug' => $this->localizedSlug($data['slug'], 'fa')], $data['fa']),
                'ar' => array_merge(['slug' => $this->localizedSlug($data['slug'], 'ar')], $data['ar']),
            ]);
        }
    }

    private function localizedSlug(string $slug, string $locale): string
    {
        $map = [
            'content-without-direction' => ['fa' => 'محتوا-بدون-جهت', 'ar' => 'محتوى-بلا-اتجاه'],
            'social-media-growth-system' => ['fa' => 'سیستم-رشد-شبکه-اجتماعی', 'ar' => 'نظام-نمو-وسائل-التواصل'],
        ];

        return $map[$slug][$locale] ?? $slug;
    }
}
