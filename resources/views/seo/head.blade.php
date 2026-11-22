<title inertia>{{ $meta['title'] }}</title>
@if (!empty($meta['canonical']) && !empty($props['rssFeedUrl']))
    <link inertia="rss-feed" rel="alternate" type="application/rss+xml" href="{{ $props['rssFeedUrl'] }}">
@endif
<meta inertia="description" name="description" content="{{ $meta['description'] }}">
@if (!empty($meta['canonical']))
    <link inertia="canonical" rel="canonical" href="{{ $meta['canonical'] }}">
@endif
<meta inertia="robots" name="robots" content="{{ $meta['robots'] ?? ((!empty($meta['noindex']) ? 'noindex' : 'index').', '.(!empty($meta['nofollow']) ? 'nofollow' : 'follow').(!empty($meta['noindex']) ? '' : ', max-image-preview:large')) }}">
@foreach (['type' => $meta['type'], 'title' => $meta['socialTitle'] ?? $meta['title'], 'description' => $meta['socialDescription'] ?? $meta['description'], 'url' => $meta['canonical'], 'site_name' => $props['settings']['siteName'] ?? config('app.name'), 'locale' => $meta['ogLocale']] as $key => $value)
    @if (filled($value))
        <meta inertia="og:{{ $key }}" property="og:{{ $key }}" content="{{ $value }}">
    @endif
@endforeach
@php $socialImage = $meta['socialImage'] ?? $meta['image'] ?? null; @endphp
@if (!empty($socialImage))
    <meta inertia="og:image" property="og:image" content="{{ $socialImage }}">
    @if (!empty($meta['socialImageAlt']))
        <meta inertia="og:image:alt" property="og:image:alt" content="{{ $meta['socialImageAlt'] }}">
    @endif
    @foreach (['socialImageWidth' => 'width', 'socialImageHeight' => 'height', 'socialImageMime' => 'type'] as $field => $property)
        @if (!empty($meta[$field]))
            <meta inertia="og:image:{{ $property }}" property="og:image:{{ $property }}" content="{{ $meta[$field] }}">
        @endif
    @endforeach
@endif
@php $twitterImage = $meta['twitterImage'] ?? $socialImage; @endphp
<meta inertia="twitter:card" name="twitter:card" content="{{ $meta['twitterCard'] ?? (empty($twitterImage) ? 'summary' : 'summary_large_image') }}">
<meta inertia="twitter:title" name="twitter:title" content="{{ $meta['twitterTitle'] ?? $meta['socialTitle'] ?? $meta['title'] }}">
<meta inertia="twitter:description" name="twitter:description" content="{{ $meta['twitterDescription'] ?? $meta['socialDescription'] ?? $meta['description'] }}">
@if (!empty($twitterImage))
    <meta inertia="twitter:image" name="twitter:image" content="{{ $twitterImage }}">
    @if (!empty($meta['twitterImageAlt']))
        <meta inertia="twitter:image:alt" name="twitter:image:alt" content="{{ $meta['twitterImageAlt'] }}">
    @endif
@endif
@if ($meta['type'] === 'article')
    @foreach (['publishedAt' => 'published_time', 'modifiedAt' => 'modified_time', 'author' => 'author'] as $key => $property)
        @if (!empty($meta[$key]))
            <meta inertia="article:{{ $property }}" property="article:{{ $property }}" content="{{ $meta[$key] }}">
        @endif
    @endforeach
@endif
@php
    $seoAlternates = array_filter($props['alternates'] ?? [], fn ($url, $code) => !isset($meta['indexableLocales']) || in_array($code, $meta['indexableLocales'], true), ARRAY_FILTER_USE_BOTH);
@endphp
@if (!empty($seoAlternates) && empty($meta['noindex']) && (!isset($meta['indexableLocales']) || in_array($props['locale']['current'] ?? '', $meta['indexableLocales'], true)))
    @foreach ($seoAlternates as $code => $url)
        <link inertia="alternate-{{ $code }}" rel="alternate" hreflang="{{ config("locales.supported.{$code}.html_lang") }}" href="{{ $url }}">
    @endforeach
    <link inertia="alternate-default" rel="alternate" hreflang="x-default" href="{{ $seoAlternates[config('locales.default')] ?? reset($seoAlternates) }}">
@endif
@foreach ($meta['structuredData'] ?? [] as $index => $data)
    <script inertia="schema-{{ $index }}" type="application/ld+json">{!! json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endforeach
