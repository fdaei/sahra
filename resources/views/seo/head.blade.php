@php
    /**
     * SEO head for responses rendered without SSR — the Blade twin of
     * resources/js/Components/SeoHead.vue. Keep the two emitting the same tags.
     *
     * Every tag carries the `inertia` attribute, exactly like SSR output, so
     * Inertia's head manager replaces them with SeoHead's tags once Vue mounts
     * instead of leaving duplicates behind.
     *
     * The Error page sends no `seo` prop (and may lack shared props when the
     * exception happened before HandleInertiaRequests ran), so it gets a
     * noindex head built from its status code.
     */
    $props = $page['props'] ?? [];
    $seo = $props['seo'] ?? null;

    if (! is_array($seo)) {
        $status = (int) ($props['status'] ?? 500);
        $key = in_array($status, [403, 404, 429, 500, 503], true) ? (string) $status : '500';

        $seo = [
            'title' => __("errors.{$key}.title"),
            'description' => __("errors.{$key}.message"),
            'image' => null,
            'canonical' => null,
            'type' => 'website',
            'noindex' => true,
            'jsonLd' => [],
        ];
    }

    $siteName = $props['settings']['siteName'] ?? config('app.name');
    $ogLocale = str_replace('-', '_', $props['locale']['htmlLang'] ?? app()->getLocale());
    $image = $seo['image'] ?? null;
@endphp
<title inertia>{{ $seo['title'] }}</title>
<meta inertia name="description" content="{{ $seo['description'] }}">
@if (! empty($seo['canonical']))
<link inertia rel="canonical" href="{{ $seo['canonical'] }}">
@endif
@if (! empty($seo['noindex']))
<meta inertia name="robots" content="noindex, follow">
@else
<meta inertia name="robots" content="index, follow, max-image-preview:large">
@endif
<meta inertia property="og:type" content="{{ $seo['type'] }}">
<meta inertia property="og:title" content="{{ $seo['title'] }}">
<meta inertia property="og:description" content="{{ $seo['description'] }}">
@if (! empty($seo['canonical']))
<meta inertia property="og:url" content="{{ $seo['canonical'] }}">
@endif
<meta inertia property="og:site_name" content="{{ $siteName }}">
<meta inertia property="og:locale" content="{{ $ogLocale }}">
@if ($image)
<meta inertia property="og:image" content="{{ $image }}">
<meta inertia property="og:image:alt" content="{{ $seo['title'] }}">
@endif
@if ($seo['type'] === 'article')
@if (! empty($seo['publishedAt']))
<meta inertia property="article:published_time" content="{{ $seo['publishedAt'] }}">
@endif
@if (! empty($seo['modifiedAt']))
<meta inertia property="article:modified_time" content="{{ $seo['modifiedAt'] }}">
@endif
@if (! empty($seo['author']))
<meta inertia property="article:author" content="{{ $seo['author'] }}">
@endif
@endif
<meta inertia name="twitter:card" content="{{ $image ? 'summary_large_image' : 'summary' }}">
<meta inertia name="twitter:title" content="{{ $seo['title'] }}">
<meta inertia name="twitter:description" content="{{ $seo['description'] }}">
@if ($image)
<meta inertia name="twitter:image" content="{{ $image }}">
@endif
@foreach ($seo['jsonLd'] ?? [] as $ld)
<script inertia type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
@endforeach
{{--
 | Until Vue mounts, the page copy rendered by seo/body is kept invisible so
 | visitors never see it flash unstyled — it exists for crawlers that read the
 | raw HTML. Without JavaScript the `js` class is never added and the copy
 | stays readable; if the bundle fails to load it is revealed after 4s.
--}}
<script>document.documentElement.classList.add('js')</script>
<style>.js [data-seo-fallback]{visibility:hidden;animation:seo-fallback-reveal 0s 4s forwards}@keyframes seo-fallback-reveal{to{visibility:visible}}</style>
