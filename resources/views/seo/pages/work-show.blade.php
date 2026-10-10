{{-- Fallback for Pages/Work/Show.vue. --}}
@php($project = $props['project'] ?? [])
<article>
    <header>
        <h1>{{ $project['title'] ?? '' }}</h1>
        @if (filled($project['excerpt'] ?? null))
            <p>{{ $project['excerpt'] }}</p>
        @endif
        <dl>
            @if (filled($project['industry'] ?? null))<dt>{{ __('work.industry') }}</dt><dd>{{ $project['industry'] }}</dd>@endif
            @if (filled($project['year'] ?? null))<dt>{{ __('work.year') }}</dt><dd>{{ $project['year'] }}</dd>@endif
            @if (! empty($project['services']))<dt>{{ __('work.services') }}</dt><dd>{{ implode(' · ', $project['services']) }}</dd>@endif
        </dl>
    </header>

    @if (filled($project['challenge'] ?? null) || ! empty($project['challengePoints']))
        <section>
            <h2>{{ __('work.challenge') }}</h2>
            @if (filled($project['challenge'] ?? null))<p>{{ $project['challenge'] }}</p>@endif
            @if (! empty($project['challengePoints']))
                <ul>@foreach ($project['challengePoints'] as $point)<li>{{ $point }}</li>@endforeach</ul>
            @endif
        </section>
    @endif

    @foreach (['goals', 'strategy', 'deliverables'] as $group)
        @if (! empty($project[$group]))
            <section>
                <h2>{{ __("work.{$group}") }}</h2>
                <ul>
                    @foreach ($project[$group] as $card)
                        <li><h3>{{ $card['title'] }}</h3>@if (filled($card['description']))<p>{{ $card['description'] }}</p>@endif</li>
                    @endforeach
                </ul>
            </section>
        @endif
    @endforeach

    @if (! empty($project['results']) || filled($project['resultsSummary'] ?? null))
        <section>
            <h2>{{ __('work.results') }}</h2>
            @if (! empty($project['results']))
                <ul>@foreach ($project['results'] as $result)<li>{{ trim($result['value'].' '.$result['label']) }}</li>@endforeach</ul>
            @endif
            @if (filled($project['resultsSummary'] ?? null))<p>{{ $project['resultsSummary'] }}</p>@endif
        </section>
    @endif

    @if (! empty($project['next']))
        <nav>
            <a href="{{ $project['next']['url'] }}">{{ __('work.next_case_study') }}: {{ $project['next']['title'] }}</a>
        </nav>
    @endif
</article>

<x-seo.section :section="$props['finalCta'] ?? null" />
