@foreach (['primaryCta', 'secondaryCta'] as $cta)
    @if (! empty($section[$cta]['label']) && ($section[$cta]['url'] ?? '#') !== '#')
        <a href="{{ $section[$cta]['url'] }}">{{ $section[$cta]['label'] }}</a>
    @endif
@endforeach
