@php($level ??= 3)
@if (! empty($services))
    <ul>
        @foreach ($services as $service)
            <li>
                <h{{ $level }}>@if (! empty($service['externalUrl']))<a href="{{ $service['externalUrl'] }}">{{ $service['title'] }}</a>@else{{ $service['title'] }}@endif</h{{ $level }}>
                @if (filled($service['description'] ?? null))
                    <p>{{ $service['description'] }}</p>
                @endif
                @if (! empty($service['features']))
                    <ul>@foreach ($service['features'] as $feature)<li>{{ $feature }}</li>@endforeach</ul>
                @endif
            </li>
        @endforeach
    </ul>
@endif
