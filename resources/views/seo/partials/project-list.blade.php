@if (! empty($projects))
    <ul>
        @foreach ($projects as $project)
            <li>
                <article>
                    <h{{ $level ?? 3 }}><a href="{{ $project['url'] }}">{{ $project['title'] }}</a></h{{ $level ?? 3 }}>
                    @if (filled($project['industry'] ?? null))
                        <p>{{ $project['industry'] }}</p>
                    @endif
                    @if (filled($project['excerpt'] ?? null))
                        <p>{{ $project['excerpt'] }}</p>
                    @endif
                    @if (! empty($project['services']))
                        <p>{{ implode(' · ', $project['services']) }}</p>
                    @endif
                </article>
            </li>
        @endforeach
    </ul>
@endif
