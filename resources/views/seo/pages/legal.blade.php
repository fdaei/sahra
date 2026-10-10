{{-- Fallback for Pages/Legal.vue. Content is admin-authored HTML, rendered with v-html there too. --}}
<article>
    <h1>{{ $props['title'] ?? '' }}</h1>
    @if (filled($props['subtitle'] ?? null))
        <p>{{ $props['subtitle'] }}</p>
    @endif
    <div>{!! $props['content'] ?? '' !!}</div>
</article>
