<title inertia>{{ $meta['title'] }}</title>
<meta inertia="description" name="description" content="{{ $meta['description'] }}">
@if (!empty($meta['canonical']))
    <link inertia="canonical" rel="canonical" href="{{ $meta['canonical'] }}">
@endif
<meta inertia="robots" name="robots" content="{{ !empty($meta['noindex']) ? 'noindex, follow' : 'index, follow, max-image-preview:large' }}">
@foreach (['type' => $meta['type'], 'title' => $meta['title'], 'description' => $meta['description'], 'url' => $meta['canonical'], 'site_name' => $props['settings']['siteName'] ?? config('app.name'), 'locale' => $meta['ogLocale']] as $key => $value)
    @if (filled($value))
        <meta inertia="og:{{ $key }}" property="og:{{ $key }}" content="{{ $value }}">
    @endif
@endforeach
@if (!empty($meta['image']))
    <meta inertia="og:image" property="og:image" content="{{ $meta['image'] }}">
    <meta inertia="og:image:alt" property="og:image:alt" content="{{ $meta['title'] }}">
    <meta inertia="twitter:image" name="twitter:image" content="{{ $meta['image'] }}">
@endif
<meta inertia="twitter:card" name="twitter:card" content="{{ empty($meta['image']) ? 'summary' : 'summary_large_image' }}">
<meta inertia="twitter:title" name="twitter:title" content="{{ $meta['title'] }}">
<meta inertia="twitter:description" name="twitter:description" content="{{ $meta['description'] }}">
@if ($meta['type'] === 'article')
    @foreach (['publishedAt' => 'published_time', 'modifiedAt' => 'modified_time', 'author' => 'author'] as $key => $property)
        @if (!empty($meta[$key]))
            <meta inertia="article:{{ $property }}" property="article:{{ $property }}" content="{{ $meta[$key] }}">
        @endif
    @endforeach
@endif
@if (!empty($props['alternates']) && empty($meta['noindex']))
    @foreach ($props['alternates'] as $code => $url)
        <link inertia="alternate-{{ $code }}" rel="alternate" hreflang="{{ config("locales.supported.{$code}.html_lang") }}" href="{{ $url }}">
    @endforeach
    <link inertia="alternate-default" rel="alternate" hreflang="x-default" href="{{ $props['alternates'][config('locales.default')] ?? reset($props['alternates']) }}">
@endif
@foreach ($meta['structuredData'] ?? [] as $index => $data)
    <script inertia="schema-{{ $index }}" type="application/ld+json">{!! json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endforeach
