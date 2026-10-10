{{-- Fallback for Pages/Insights/Show.vue. Post content is admin-authored HTML, rendered with v-html there too. --}}
@php($post = $props['post'] ?? [])
<article>
    <header>
        @if (! empty($post['category']['name']))
            <p>{{ $post['category']['name'] }}</p>
        @endif
        <h1>{{ $post['title'] ?? '' }}</h1>
        @if (filled($post['subtitle'] ?? null))
            <p>{{ $post['subtitle'] }}</p>
        @endif
        @if (filled($post['publishedAtIso'] ?? null))
            <time datetime="{{ $post['publishedAtIso'] }}">{{ $post['publishedAt'] }}</time>
        @endif
        @if (! empty($post['author']['name']))
            <p>{{ __('blog.written_by') }} {{ $post['author']['name'] }}</p>
        @endif
    </header>

    <div>{!! $post['content'] ?? '' !!}</div>

    @if (! empty($post['tags']))
        <footer>
            <h2>{{ __('blog.tags') }}</h2>
            <ul>@foreach ($post['tags'] as $tag)<li>{{ $tag['name'] }}</li>@endforeach</ul>
        </footer>
    @endif
</article>

@if (! empty($post['related']))
    <section>
        <h2>{{ __('blog.related') }}</h2>
        @include('seo.partials.post-list', ['posts' => $post['related']])
    </section>
@endif

<x-seo.section :section="$props['finalCta'] ?? null" />
