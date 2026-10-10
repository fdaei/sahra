<ul>
    @foreach ($items as $item)
        <li>
            <a href="{{ $item['url'] }}"@if (($item['target'] ?? '_self') === '_blank') target="_blank" rel="noopener"@endif>{{ $item['label'] }}</a>
            @if (! empty($item['children']))
                @include('seo.partials.nav', ['items' => $item['children']])
            @endif
        </li>
    @endforeach
</ul>
