{{-- Fallback for Pages/Home.vue. --}}
@php
    $sections = $props['sections'] ?? [];
    $hero = $sections['hero'] ?? null;
@endphp
@if ($hero)
    <section>
        <h1>{{ implode(' ', array_filter([$hero['title'] ?? '', $hero['content'] ?? '', $hero['description'] ?? ''], 'filled')) }}</h1>
        @if (filled($hero['subtitle'] ?? null))
            <p>{{ $hero['subtitle'] }}</p>
        @endif
        @include('seo.partials.ctas', ['section' => $hero])
    </section>
@else
    <h1>{{ $props['seo']['title'] ?? '' }}</h1>
@endif

<x-seo.section :section="$sections['kpi'] ?? null" />

<x-seo.section :section="$sections['trust_proof'] ?? null">
    @if (! empty($props['clients']))
        <ul>
            @foreach ($props['clients'] as $client)
                <li>@if ($client['url'])<a href="{{ $client['url'] }}" rel="noopener">{{ $client['name'] }}</a>@else{{ $client['name'] }}@endif</li>
            @endforeach
        </ul>
    @endif
</x-seo.section>

<x-seo.section :section="$sections['services_cloud'] ?? null">
    @include('seo.partials.service-list', ['services' => $props['services'] ?? []])
</x-seo.section>

<x-seo.section :section="$sections['lead_magnet'] ?? null" />

<x-seo.section :section="$sections['projects_showcase'] ?? null">
    @include('seo.partials.project-list', ['projects' => $props['projects'] ?? []])
</x-seo.section>

<x-seo.section :section="$sections['process'] ?? null" />
<x-seo.section :section="$sections['packages'] ?? null" />
<x-seo.section :section="$sections['why_us'] ?? null" />

<x-seo.section :section="$sections['reviews'] ?? null">
    @foreach ($props['testimonials'] ?? [] as $testimonial)
        <figure>
            <blockquote>{{ $testimonial['quote'] }}</blockquote>
            <figcaption>{{ trim($testimonial['name'].($testimonial['role'] ? ', '.$testimonial['role'] : '')) }}</figcaption>
        </figure>
    @endforeach
</x-seo.section>

<x-seo.section :section="$sections['insights'] ?? null">
    @include('seo.partials.post-list', ['posts' => $props['posts'] ?? []])
</x-seo.section>

<x-seo.section :section="$sections['faq'] ?? null">
    @include('seo.partials.faq-list', ['faqs' => $props['faqs'] ?? []])
</x-seo.section>

<x-seo.section :section="$sections['final_cta'] ?? null" />
