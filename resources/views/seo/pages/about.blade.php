{{-- Fallback for Pages/About.vue. --}}
@php
    $sections = $props['sections'] ?? [];
    $hero = $sections['about_hero'] ?? null;
@endphp
<section>
    <h1>{{ $hero ? implode(' ', array_filter([$hero['title'] ?? '', $hero['content'] ?? ''], 'filled')) : ($props['seo']['title'] ?? '') }}</h1>
    @if (filled($hero['description'] ?? null))
        <p>{{ $hero['description'] }}</p>
    @endif
</section>

<x-seo.section :section="$sections['story'] ?? null" />
<x-seo.section :section="$sections['how_we_think'] ?? null" />

<x-seo.section :section="$sections['team'] ?? null">
    @if (! empty($props['team']))
        <ul>
            @foreach ($props['team'] as $member)
                <li><h3>{{ $member['name'] }}</h3>@if (filled($member['role']))<p>{{ $member['role'] }}</p>@endif</li>
            @endforeach
        </ul>
    @endif
</x-seo.section>

<x-seo.section :section="$sections['final_cta'] ?? null" />
