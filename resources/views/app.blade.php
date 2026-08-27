@php
    /**
     * Inertia root view.
     *
     * Sets lang/dir from the resolved locale so the very first paint is already
     * correct — no flash of LTR before Vue hydrates. The font class picks the
     * Poppins (EN) or Doran/Vazirmatn (FA/AR) stack defined in tailwind.config.js.
     */
    $locale    = app()->getLocale();
    $config    = config("locales.supported.{$locale}");
    $direction = $config['direction'];
    $htmlLang  = $config['html_lang'];
    $fontClass = $config['font'] === 'arabic' ? 'font-arabic' : 'font-sans';

    /**
     * Analytics/tracking IDs, entered in Filament → Site settings →
     * Integrations & analytics. Each snippet is skipped entirely when its ID
     * is blank, so an unconfigured integration renders nothing.
     */
    $integrations = \App\Support\SiteSettings::integrations();
@endphp
<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $direction }}" class="{{ $fontClass }} antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (filled($integrations['gtmId']))
        {{-- Google Tag Manager --}}
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer',{{ Illuminate\Support\Js::from($integrations['gtmId']) }});</script>
    @endif

    @if (filled($integrations['gscVerification']))
        <meta name="google-site-verification" content="{{ $integrations['gscVerification'] }}">
    @endif

    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#231F20">

    {{-- Self-hosted fonts: see docs/ASSET-MANIFEST.md §10 --}}
    @if ($config['font'] === 'arabic')
        <link rel="preload" href="/fonts/doran/DoranFaNum-Regular.ttf" as="font" type="font/ttf" crossorigin>
        <link rel="preload" href="/fonts/doran/DoranFaNum-Medium.ttf" as="font" type="font/ttf" crossorigin>
    @else
        <link rel="preload" href="/fonts/poppins/Poppins-Regular.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="/fonts/poppins/Poppins-SemiBold.woff2" as="font" type="font/woff2" crossorigin>
    @endif

    {{-- hreflang: every page in every language + x-default --}}
    @isset($page['props']['alternates'])
        @foreach ($page['props']['alternates'] as $code => $url)
            <link rel="alternate" hreflang="{{ config("locales.supported.{$code}.html_lang") }}" href="{{ $url }}">
        @endforeach
        <link rel="alternate" hreflang="x-default"
              href="{{ $page['props']['alternates'][config('locales.default')] ?? url('/') }}">
    @endisset

    @if (filled($integrations['gaId']))
        {{-- Google Analytics (GA4) --}}
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $integrations['gaId'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', {{ Illuminate\Support\Js::from($integrations['gaId']) }});
        </script>
    @endif

    @if (filled($integrations['hotjarId']))
        {{-- Hotjar --}}
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:{{ (int) $integrations['hotjarId'] }},hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    @endif

    @routes
    @vite(['resources/js/app.ts'])
    @inertiaHead
</head>
<body class="bg-paper text-neutral-900">
    @if (filled($integrations['gtmId']))
        {{-- Google Tag Manager (noscript) --}}
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $integrations['gtmId'] }}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    {{-- Skip link — first focusable element, revealed on focus --}}
    <a href="#main"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:inline-start-4 focus:z-modal
              focus:rounded-sm focus:bg-ink focus:px-4 focus:py-3 focus:text-paper">
        {{ __('common.skip_to_content') }}
    </a>

    @inertia
</body>
</html>
