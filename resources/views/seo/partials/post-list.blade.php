@if (! empty($posts))
    <ul>
        @foreach ($posts as $post)
            <li>
                <article>
                    <h{{ $level ?? 3 }}><a href="{{ $post['url'] }}">{{ $post['title'] }}</a></h{{ $level ?? 3 }}>
                    @if (! empty($post['category']['name']))
                        <p>{{ $post['category']['name'] }}</p>
                    @endif
                    @if (filled($post['publishedAtIso'] ?? null))
                        <time datetime="{{ $post['publishedAtIso'] }}">{{ $post['publishedAt'] }}</time>
                    @endif
                    @if (filled($post['excerpt'] ?? null))
                        <p>{{ $post['excerpt'] }}</p>
                    @endif
                </article>
            </li>
        @endforeach
    </ul>
@endif
