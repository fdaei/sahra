{{-- Fallback for Pages/Insights/Index.vue. --}}
@php
    $posts = $props['posts'] ?? [];
    $list = array_values(array_filter([$props['featured'] ?? null, ...($posts['data'] ?? [])]));
@endphp
<section>
    @include('seo.partials.heading', ['heading' => $props['heading'] ?? []])
    @include('seo.partials.post-list', ['posts' => $list, 'level' => 2])

    @if (! empty($posts['prevPageUrl']) || ! empty($posts['nextPageUrl']))
        <nav aria-label="{{ __('common.pagination') }}">
            @if (! empty($posts['prevPageUrl']))<a href="{{ $posts['prevPageUrl'] }}" rel="prev">{{ __('common.previous') }}</a>@endif
            @if (! empty($posts['nextPageUrl']))<a href="{{ $posts['nextPageUrl'] }}" rel="next">{{ __('common.next') }}</a>@endif
        </nav>
    @endif
</section>

<x-seo.section :section="$props['sections']['final_cta'] ?? null" />
