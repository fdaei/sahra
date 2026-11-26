@php
    $locale    = app()->getLocale();
    $config    = config("locales.supported.{$locale}");
    $direction = $config['direction'];
    $htmlLang  = $config['html_lang'];
    $fontClass = $config['font'] === 'arabic' ? 'font-arabic' : 'font-sans';

    $minimal = $template === 'public.pages.error';
    $settings = $minimal ? [] : \App\Support\SiteSettings::forFrontend($locale);
    $integrations = $minimal ? [] : \App\Support\SiteSettings::integrations();
    $alternates = $minimal ? [] : \App\Support\LocaleAlternates::for(request());
    $rssFeedUrl = $minimal ? null : \App\Support\CanonicalUrl::route('feed.locale', ['locale' => $locale]);
    $priorityImage = match ($template) {
        'public.pages.home' => $sections['hero']['image']['src'] ?? null,
        'public.pages.services' => $services[0]['imagePreview'] ?? $services[0]['image']['src'] ?? null,
        'public.pages.work.index' => $projects[0]['imagePreview'] ?? $projects[0]['image']['src'] ?? null,
        'public.pages.insights.index' => $featured['image']['src'] ?? null,
        'public.pages.insights.show' => $post['image']['src'] ?? null,
        default => null,
    };
@endphp
<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $direction }}" class="{{ $fontClass }} antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @if ($priorityImage)
        <link rel="preload" as="image" href="{{ $priorityImage }}" fetchpriority="high">
    @elseif ($template === 'public.pages.home' && !empty($sections['hero']))
        <link rel="preload" as="image" href="/images/sahra/hero-brand-preview-mobile.webp" media="(width < 768px)" fetchpriority="high">
        <link rel="preload" as="image" href="/images/sahra/hero-brand-preview-1024.webp" media="(width >= 768px)" fetchpriority="high">
    @endif

    @if (filled($integrations['gscVerification'] ?? null))
        <meta name="google-site-verification" content="{{ $integrations['gscVerification'] }}">
    @endif

    <link rel="icon" href="/favicon.ico" sizes="32x32">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#231F20">

    {{-- Self-hosted fonts: see docs/ASSET-MANIFEST.md §10 --}}
    @if ($config['font'] === 'arabic')
        <link rel="preload" href="/fonts/doran/DoranFaNum-Regular.woff2" as="font" type="font/woff2" crossorigin>
    @else
        <link rel="preload" href="/fonts/poppins/Poppins-Regular-Latin.woff2" as="font" type="font/woff2" crossorigin>
    @endif

    @include('seo.head', ['meta' => $seo])

    @vite(['resources/css/app.css', 'resources/js/public.js'])
</head>
<body class="bg-paper text-neutral-900"
    @if (filled($integrations['gtmId'] ?? null)) data-gtm-id="{{ $integrations['gtmId'] }}" @endif
    @if (filled($integrations['gaId'] ?? null)) data-ga-id="{{ $integrations['gaId'] }}" @endif
    @if (filled($integrations['hotjarId'] ?? null)) data-hotjar-id="{{ $integrations['hotjarId'] }}" @endif
>
    @if (filled($integrations['gtmId'] ?? null))
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

    @include('public.layouts.app-header')

    <main id="main" class="relative min-h-screen-safe">
        @if (count($seo['breadcrumbs'] ?? []) > 1)
            @include('public.components.breadcrumbs', ['items' => $seo['breadcrumbs']])
        @endif

        @include($template)

        @include('public.components.schema-blocks', ['schemaBlocks' => $seo['schemaBlocks'] ?? []])
    </main>

    @unless ($minimal)
        @include('public.layouts.app-footer')
    @endunless

    @if (!$minimal && session('error'))
        <p role="alert" class="fixed inset-inline-0 bottom-6 z-modal mx-auto w-fit max-w-[90vw] rounded-sm bg-red-600 px-6 py-4 text-white shadow-card">
            {{ session('error') }}
        </p>
    @endif
</body>
</html>
