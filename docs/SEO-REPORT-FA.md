# گزارش اصلاح سئوی فنی

## معماری بررسی‌شده و تصمیم اجرایی

کد واقعی پروژه Laravel 12، Inertia 2، Vue 3، Vite و Filament است. صفحات عمومی از کنترلرهای PHP، مدل‌های دارای جدول ترجمه و وضعیت انتشار ساخته می‌شوند. زبان پیش‌فرض `en` حفظ شده؛ فارسی و عربی `rtl` هستند. وضعیت اولیهٔ Git فقط شامل تغییر موجود کاربر در `database/database.sqlite` بود و این فایل حفظ شده است.

قبل از اصلاح، `app.blade.php` به `@inertia` و `@inertiaHead` متکی بود. تنظیمات Inertia، build و Docker سرویس Node SSR را فعال می‌کردند؛ `RequiredSsrGateway` در تولید، نبودن سرویس را به پاسخ 503 تبدیل می‌کرد. بدون SSR، بدنهٔ عمومی فقط ریشهٔ برنامه و دادهٔ JSON داشت.

اکنون Blade مستقیماً از همان `page.props` حل‌شدهٔ کنترلرها HTML عمومی می‌سازد. دادهٔ جداگانه، snapshot زمان build یا نسخهٔ مخصوص ربات وجود ندارد. تغییر متن و انتشار پنل در درخواست بعدی PHP دیده می‌شود. Vue با `createApp` محتوای اولیه را در همان ریشه جایگزین می‌کند؛ از hydration ناسازگار استفاده نمی‌شود. چیدمان خواندن بدون JavaScript ساده‌تر از طراحی Vue است؛ متن اصلی و لینک‌ها در هر دو حالت از همان دادهٔ عمومی می‌آیند. برای سنجش تغییر چیدمان و کارایی باید اندازه‌گیری مستقلی انجام شود.

## مشکلات و اصلاحات

| مشکل واقعی | اصلاح |
| --- | --- |
| ورود به دامنهٔ اصلی با زبان مرورگر یا session به فارسی تغییر می‌کرد | هدایت پایدار 301 به زبان پیش‌فرض انگلیسی؛ حفظ آدرس‌های صریح فارسی/عربی؛ تست مرورگر فارسی و session فارسی با JavaScript روشن/خاموش |
| صفحهٔ جدید ابتدا در موقعیت اسکرول صفحهٔ قبلی دیده می‌شد | اجرای فوری reset پیش‌فرض Inertia با حذف اسکرول نرم سراسری و همگام‌سازی حافظهٔ GSAP با موقعیت مقصد، برای جلوگیری از بازگردانی اسکرول قدیمی هنگام refresh؛ تست ناوبری از footer با motion عادی |
| وابستگی HTML و head اولیه به Node و احتمال 503 | تولید بدنه و head با Blade؛ غیرفعال کردن SSR حتی با `.env` قدیمی؛ حذف gateway، خطای SSR، entry و build سرویس Node |
| نبود متن کامل مقاله، پروژه و صفحات در HTML بدون SSR | قالب‌های PHP برای صفحات اصلی، بخش‌ها، فهرست‌ها، مقالهٔ کامل، جزئیات پروژه، خدمات، قوانین، تصاویر و لینک‌های داخلی |
| تشخیص اشتباه هر HTML موجود به‌عنوان Vue SSR | نصب با `createApp` و جایگزینی ریشه؛ بررسی نبود خطای hydration و محتوای تکراری |
| head اولیه فاقد title، description و canonical | تولید PHP از `SeoBuilder` و مصرف همان payload در Vue |
| hreflang ثابت و باقی ماندن آدرس صفحهٔ قبلی در ناوبری | headهای مدیریت‌شده با کلید یکسان در Blade و Inertia؛ به‌روز شدن hreflang، canonical، OG و schema هنگام ناوبری و back |
| مقدار نامناسب OG locale و تصویر اشتراک نسبی | مقادیر `en_US`، `fa_IR`، `ar_OM` و URL مطلق تصویر |
| URL سازمان/وب‌سایت برابر URL هر مقاله و استفاده از عکس مقاله به‌عنوان لوگو | شناسه و URL ثابت سازمان و وب‌سایت؛ حذف ادعای لوگوی نادرست؛ Article با عنوان واقعی محتوا و CreativeWork برای مطالعهٔ موردی |
| صفحات خطا با canonical/hreflang احتمالی نامعتبر | 404 واقعی، noindex، بدون canonical یا hreflang ساختگی |
| صفحات معمولی پیش‌نویس پاسخ خالی 200 می‌دادند | نیاز به Page منتشرشده و پاسخ 404 برای صفحهٔ منتشرنشده یا غایب |
| sitemap همهٔ مسیرهای ثابت را حتی بدون صفحهٔ منتشرشده درج می‌کرد | خواندن صفحات و جزئیات منتشرشده از دیتابیس؛ فقط slugهای موجود هر زبان؛ دامنهٔ canonical یکسان |
| `lastmod` زمان جاری و در نتیجه غیرواقعی | حذف زمان حدسی sitemap؛ تاریخ اصلاح Article از رکورد و ترجمهٔ واقعی آن |
| canonical صفحه‌بندی به صفحهٔ اول برمی‌گشت و صفحهٔ بعد noindex می‌شد | canonical مستقل با `page`؛ صفحه‌بندی عمومی index/follow؛ فیلتر/جست‌وجو noindex/follow؛ صفحهٔ خارج از محدوده 404 |
| کنار گذاشتن مقالهٔ ویژه فقط در صفحهٔ اول باعث جابه‌جایی/حذف نتیجه در صفحهٔ دوم می‌شد | کنار گذاشتن مقالهٔ ویژه از query فهرست در تمام صفحات بدون فیلتر |
| بارگذاری بخش‌های پروژه بدون رعایت `is_visible` | استفاده از query جزئیات عمومی؛ حذف بخش و item مخفی و خدمات پیش‌نویس از payload و HTML |
| کش ۲۴ساعتهٔ دسته‌بندی مقاله بدون invalidation پس از ویرایش پنل | خواندن دسته‌بندی از دیتابیس در درخواست عمومی و تست انعکاس فوری ویرایش |
| گزینهٔ زبان بدون ترجمه می‌توانست href نداشته باشد | نمایش فقط زبان‌های دارای آدرس ترجمهٔ واقعی در سوئیچر |
| URL تصویر با اندازه‌های 448، 294 و غیره به مسیری می‌رفت که فقط 400/736/1200 می‌پذیرفت | انتخاب اندازهٔ پشتیبانی‌شده؛ حفظ SVG و تصاویر خارجی |
| کنترلر تصویر خروجی فایل را با نوع Response نادرست اعلام کرده بود | استفاده از BinaryFileResponse؛ fallback تصویر اصلی و جلوگیری از تولید JPEG با پسوند AVIF/WebP بدون encoder |
| کش immutable تصویر و عدم بررسی تغییر منبع | بازتولید نسخه در صورت جدیدتر بودن منبع و کش محدود به یک ساعت |
| پنل صرفاً در robots.txt مسدود بود | هدر `X-Robots-Tag` برای Filament و دانلود خصوصی؛ robots.txt زنده با آدرس sitemap واقعی حفظ شده |
| استقرار به symlink، صف worker و کش ساخته‌شده روی توسعه وابسته می‌شد | مسیر اختیاری `PUBLIC_STORAGE_ROOT`، نمونهٔ محیط `sync/file`، ورودی PHP سی‌پنل و ZIP با vendor تولید بدون کش محلی |

## فایل‌های تغییرکرده

- تولید HTML: `resources/views/app.blade.php`، قالب‌های جدید `resources/views/public/{page,section,cards,image,navigation,contact}.blade.php` و `resources/views/seo/head.blade.php`.
- داده و انتشار عمومی: `app/Http/Controllers/{Home,About,Service,Contact,Post,Project,Sitemap}Controller.php`، `app/Models/{Post,Project}.php` و `app/Traits/HasTranslations.php` (شرط مشترک وجود مقدار ترجمه، بدون fallback).
- SEO و تصاویر: `app/Services/{SeoBuilder,MediaTransformer}.php`، `app/Http/Controllers/MediaVariantController.php`، `app/Support/LocaleAlternates.php`، `resources/views/sitemap/index.blade.php`.
- ظاهر و رابط Vue: `resources/css/app.css`، `resources/js/app.ts`، `Components/{SeoHead,LanguageSwitcher}.vue`، `Pages/{Error,Insights/Show}.vue` و `types/index.ts`.
- تنظیمات و پنل: `bootstrap/app.php`، `app/Providers/{AppServiceProvider,Filament/AdminPanelProvider}.php`، `app/Http/Middleware/{HandleInertiaRequests,PreventPrivateIndexing,RedirectToLocalisedRoute}.php`، `config/{inertia,seo,filesystems,database}.php`.
- حذف وابستگی Node در اجرا: `package.json`، `vite.config.ts`، `Dockerfile`، `docker-compose.yml`، `.env.example` و `.env.docker.example`. فایل‌های قدیمی `resources/js/ssr.ts`، `RequiredSsrGateway.php`، `SsrUnavailable.php` و قالب خطای SSR حذف شده‌اند.
- تحویل و راهنما: `.env.cpanel.example`، `deployment/cpanel/index.php`، `scripts/build-cpanel.php`، `README.md`، `.gitignore` و این دو سند فارسی.
- بررسی‌ها: `phpunit.xml`، `tests/Pest.php`، `tests/Feature/Seo/{PublicHtmlTest,MediaTest}.php`، `tests/Feature/Locale/LocaleRoutingTest.php`، `tests/Browser/seo.spec.ts`، `playwright.seo.config.ts`، `scripts/create-seo-fixture.php` و `scripts/test-seo.mjs`.

تغییر سازگاری `PDO` در `config/database.php` هشدار PHP 8.5 را رفع می‌کند و شاخهٔ PHP 8.2 را حفظ می‌کند. برای تست‌های قدیمی فرم، ایمیل‌های رزروشدهٔ `example.com` فقط در محیط تست بدون DNS خارجی و با بررسی RFC اعتبارسنجی می‌شوند؛ اعتبارسنجی تولید تغییر نکرده است.

## بررسی‌های انجام‌شده

نتیجهٔ نهایی: **۷۱ تست PHP، ۲۸۸ assertion، شش تست مرورگر و هفت مسیر آزمون HTML بدون JavaScript موفق شدند.**

- تست‌های PHP روی SQLite حافظه‌ای با `DB_CONNECTION=sqlite` و `DB_DATABASE=:memory:` اجباری اجرا شدند. JSON و scriptها از DOM حذف می‌شوند و متن در `body main`، heading، تصویر و لینک بررسی می‌شود.
- ورود پیش‌فرض انگلیسی با هدرهای فارسی/عربی، session فارسی/عربی و پارامترهای query بررسی شد؛ `x-default` صفحات دارای نسخهٔ انگلیسی به همان نسخه اشاره می‌کند و URL صریح فارسی همچنان فارسی است.
- پوشش تست: همهٔ انواع صفحهٔ عمومی، متن کامل مقاله، تغییر زندهٔ متن، draft/scheduled/future/deleted، بخش و item مخفی پروژه، slug زبان، XML معتبر sitemap، robots، canonical صفحه‌بندی، 404 و noindex و برابری بدنهٔ کاربر/Googlebot.
- تست مرورگر Chromium روی دیتابیس مستقل `/tmp/sdk-seo-browser-1.sqlite` ساخته‌شده از fixture اجرا شد. هیچ migration یا seed روی دیتابیس کاربر اجرا نشد.
- با JavaScript خاموش و روشن، صفحات اصلی، فهرست، جزئیات پروژه و مقاله، قوانین و متن فارسی خوانا بودند. نبود خطای JavaScript/hydration و یک‌بودن `h1`، title و canonical بررسی شد.
- تست اسکرول با `prefers-reduced-motion: no-preference` اجرا شد: پیش از اصلاح، صفحهٔ مقصد با offset برابر ۳۸۳۶ پیکسل باز می‌شد؛ پس از اصلاح، offset در رویداد ناوبری و پس از نمایش محتوای مقصد صفر است. همچنین حافظهٔ داخلی ScrollTrigger با موقعیت تازه همگام می‌شود تا refresh انیمیشن‌ها آن را برنگرداند؛ [مستندات GSAP](https://gsap.com/docs/v3/Plugins/ScrollTrigger/static.clearScrollMemory()/) این کاربرد در مسیریابی را توضیح می‌دهد.
- در ناوبری واقعی Inertia به مقاله و بازگشت به فهرست، title، canonical، hreflang، OG type، schema و حذف متاتگ‌های مخصوص مقاله بررسی شدند. همین شش سناریو روی بستهٔ سی‌پنل با vendor بدون وابستگی توسعه نیز موفق شدند. marker روی window نشان داد ناوبری در همان document انجام شده است.
- `npm run build` شامل typecheck و Vite موفق شد و خروجی واقعی `public/build/manifest.json` و assets ساخته شد. هشدارهای resolve زمان build مربوط به URLهای ثابت `/fonts` و `/images` بودند؛ این فایل‌ها در `public` نگهداری و در بسته کپی می‌شوند.
- مقدار SHA256 دیتابیس محلی موجود پس از کار با مقدار ثبت‌شده قبل از تست‌ها یکسان است.

## نیازمند دسترسی هاست واقعی

تنظیم دامنه و Document Root، نسخه/افزونه‌های PHP، SSL و redirectهای Apache، مجوز نوشتن، اتصال MySQL، موجودبودن رسانه‌ها، تحویل SMTP، OPcache و امکان cron باید در سی‌پنل بررسی شوند. انتقال واقعی دیتابیس و رسانه و استقرار روی هاست در این محیط انجام نشده است. انتشار scheduled بدون cron PHP نیاز به تغییر دستی وضعیت از پنل دارد.

برای صحت رتبهٔ گوگل یا سرعت سایت ادعایی نشده است. مبنای انتخاب روش نصب Vue، رفتار `createApp.mount` در [مستندات رسمی Vue](https://vuejs.org/api/application.html#app-mount) و قرارداد رندر موجود در نسخهٔ نصب‌شدهٔ Inertia است؛ SSR استاندارد Inertia به [پردازش Node](https://inertiajs.com/server-side-rendering) وابسته است.

## زبان پیش‌فرض و نتایج گوگل

`APP_LOCALE=en` از قبل تنظیم بود، اما middleware ورود بدون زبان، session و سپس `Accept-Language` را بر آن مقدم می‌کرد. بنابراین حالت ناشناس هم با مرورگر فارسی می‌توانست `/fa` باز کند؛ توضیح «فقط کش مرورگر» کافی نبود. اکنون دامنهٔ اصلی و مسیرهای بدون زبان، مستقل از این دو عامل، به نسخهٔ انگلیسی redirect دائمی می‌شوند. نسخه‌های فارسی و عربی و canonical مستقلشان حفظ شده‌اند.

نمایش نتیجهٔ فارسی در جست‌وجو با زبان ورود دامنه یک موضوع نیست. اگر نتیجهٔ گوگل مستقیماً URL فارسی باشد، همان صفحهٔ فارسی باز می‌شود. گوگل تلاش می‌کند نسخه‌ای متناسب با زبان جست‌وجوکننده نشان دهد؛ `x-default` و تغییر redirect، دستور قطعی برای اول بودن نتیجهٔ انگلیسی نیستند. [راهنمای رسمی گوگل](https://developers.google.com/search/docs/specialty/international/managing-multi-regional-sites) این رفتار و استفاده از URLهای مستقل زبان‌ها را توضیح می‌دهد.

بعد از استقرار، بررسی URL انگلیسی و sitemap در Search Console و وضعیت ایندکس به دسترسی حساب نیاز دارد. فارسی از ایندکس حذف نشده و همهٔ canonicalها به انگلیسی تغییر نکرده‌اند؛ چنین کاری نسخه‌های ترجمه‌شده را از جست‌وجو خارج یا دچار تناقض می‌کند.
