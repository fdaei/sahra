@php
    /**
     * Page copy for responses rendered without SSR, placed inside the Inertia
     * root so crawlers that read the raw HTML (Bing, social previews, SEO
     * tools) get the headings, text and internal links that Vue would render.
     *
     * resources/js/app.ts recognises the [data-seo-fallback] marker and mounts
     * a fresh app over it (createApp clears the root) instead of hydrating.
     * Images are left out on purpose: the copy is hidden until Vue mounts and
     * would only compete with the real page for bandwidth.
     *
     * One partial per Inertia component in seo/pages, named after it
     * ("Work/Show" -> seo.pages.work-show). Keep each in step with its page.
     */
    $props = $page['props'] ?? [];
    $locale = $props['locale']['current'] ?? app()->getLocale();
    $settings = $props['settings'] ?? [];
    $navigation = $props['navigation'] ?? ['header' => [], 'footer' => []];
    $view = 'seo.pages.'.strtolower(str_replace('/', '-', (string) ($page['component'] ?? '')));
@endphp
<div data-seo-fallback>
    <header>
        <a href="/{{ $locale }}">{{ $settings['siteName'] ?? config('app.name') }}</a>
        @if (! empty($navigation['header']))
            <nav aria-label="{{ __('common.primary_navigation') }}">
                @include('seo.partials.nav', ['items' => $navigation['header']])
            </nav>
        @endif
        @if (! empty($props['alternates']) && count($props['alternates']) > 1)
            <nav aria-label="{{ __('common.change_language') }}">
                <ul>
                    @foreach ($props['alternates'] as $code => $url)
                        @continue($code === $locale)
                        <li><a href="{{ $url }}" hreflang="{{ config("locales.supported.{$code}.html_lang", $code) }}" lang="{{ config("locales.supported.{$code}.html_lang", $code) }}">{{ config("locales.supported.{$code}.native", $code) }}</a></li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </header>

    <main id="main">
        @includeIf($view, ['props' => $props])
    </main>

    <footer>
        @if (! empty($settings['description']))
            <p>{{ $settings['description'] }}</p>
        @endif
        @if (! empty($navigation['footer']))
            <nav>
                @include('seo.partials.nav', ['items' => $navigation['footer']])
            </nav>
        @endif
        @php($contact = $settings['contact'] ?? [])
        @if (array_filter($contact))
            <address>
                @if (! empty($contact['email']))<a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>@endif
                @if (! empty($contact['phone']))<a href="tel:{{ preg_replace('/[^\d+]/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a>@endif
                @if (! empty($contact['location']))<span>{{ $contact['location'] }}</span>@endif
            </address>
        @endif
        @if (! empty($settings['socialLinks']))
            <ul>
                @foreach ($settings['socialLinks'] as $social)
                    <li><a href="{{ $social['url'] }}" rel="noopener">{{ $social['label'] ?: $social['platform'] }}</a></li>
                @endforeach
            </ul>
        @endif
    </footer>
</div>
