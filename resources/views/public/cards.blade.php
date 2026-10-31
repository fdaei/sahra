<div class="grid gap-8 md:grid-cols-2">
    @foreach ($cards as $card)
        <article class="py-6">
            <h2 class="text-title-lg"><a href="{{ $card['url'] }}">{{ $card['title'] }}</a></h2>
            @include('public.image', ['image' => $card['image'] ?? null])
            <p>{{ $card['excerpt'] ?? '' }}</p>
            <p>{{ $card['category']['name'] ?? $card['industry'] ?? '' }}</p>
            @if (!empty($card['services']))<p>{{ implode(', ', $card['services']) }}</p>@endif
            @if (!empty($card['publishedAtIso']))
                <time datetime="{{ $card['publishedAtIso'] }}">{{ $card['publishedAt'] }}</time>
            @endif
        </article>
    @endforeach
</div>
