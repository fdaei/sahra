{{--
 | One editorial PageSection (ContentTransformer::section) as plain semantic
 | HTML for the no-SSR fallback (see seo/body). The slot holds the entity list
 | the section introduces — services, projects, posts — so it sits under the
 | section's own heading.
--}}
@props(['section' => null])
@if (is_array($section))
    <section>
        @if (filled($section['eyebrow'] ?? null))
            <p>{{ $section['eyebrow'] }}</p>
        @endif
        @if (filled($section['title'] ?? null))
            <h2>{{ $section['title'] }}</h2>
        @endif
        @foreach (['subtitle', 'description', 'content'] as $field)
            @if (filled($section[$field] ?? null))
                <p>{{ $section[$field] }}</p>
            @endif
        @endforeach

        @if (! empty($section['items']))
            <ul>
                @foreach ($section['items'] as $item)
                    <li>
                        @if (filled($item['title'] ?? null))
                            <h3>{{ $item['title'] }}</h3>
                        @endif
                        @if (filled($item['value'] ?? null) || filled($item['label'] ?? null))
                            <p>{{ trim(($item['value'] ?? '').($item['suffix'] ?? '').' '.($item['label'] ?? '')) }}</p>
                        @endif
                        @foreach (['badge', 'description', 'footer'] as $field)
                            @if (filled($item[$field] ?? null))
                                <p>{{ $item[$field] }}</p>
                            @endif
                        @endforeach
                        @if (! empty($item['features']))
                            <ul>
                                @foreach ($item['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        {{ $slot }}

        @include('seo.partials.ctas', ['section' => $section])
    </section>
@elseif ($slot->isNotEmpty())
    <section>{{ $slot }}</section>
@endif
