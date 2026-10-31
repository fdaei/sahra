@foreach ($items as $item)
    <li class="my-2">
        @if (filled($item['url']))
            <a href="{{ $item['url'] }}" target="{{ $item['target'] }}" @if ($item['target'] === '_blank') rel="noopener" @endif>{{ $item['label'] }}</a>
        @else
            <span>{{ $item['label'] }}</span>
        @endif
        @if (!empty($item['children']))
            <ul class="ps-6">@include('public.navigation', ['items' => $item['children']])</ul>
        @endif
    </li>
@endforeach
