<section class="my-16" @if (!empty($section['type'])) id="{{ $section['type'] }}" @endif>
    <p class="eyebrow">{{ $section['eyebrow'] ?? '' }}</p>
    @if (!empty($section['title']))
        <{{ $level ?? 'h2' }} class="text-heading-xl">{{ $section['title'] }}</{{ $level ?? 'h2' }}>
    @endif
    <p class="text-title-sm">{{ $section['subtitle'] ?? '' }}</p>
    <p class="whitespace-pre-line">{{ $section['description'] ?? '' }}</p>
    {{-- Authored rich text, from the same public DTO used by Vue. --}}
    <div class="prose max-w-none">{!! $section['content'] ?? '' !!}</div>
    @include('public.image', ['image' => $section['image'] ?? null, 'eager' => ($level ?? '') === 'h1'])
    @foreach ($section['items'] ?? [] as $item)
        <article class="my-8">
            <p>{{ $item['badge'] ?? '' }}</p>
            <h3 class="text-title-lg">{{ $item['title'] ?? '' }}</h3>
            <p>{{ $item['value'] ?? '' }}{{ $item['suffix'] ?? '' }} {{ $item['label'] ?? '' }}</p>
            <p class="whitespace-pre-line">{{ $item['description'] ?? '' }}</p>
            @if (!empty($item['features']))
                <ul class="list-disc ps-6">@foreach ($item['features'] as $feature)<li>{{ $feature }}</li>@endforeach</ul>
            @endif
            <p>{{ $item['footer'] ?? '' }}</p>
            @include('public.image', ['image' => $item['image'] ?? null])
        </article>
    @endforeach
    @foreach (['primaryCta', 'secondaryCta'] as $key)
        @if (!empty($section[$key]['url']))
            <a class="me-6 inline-block py-4 underline" href="{{ $section[$key]['url'] }}">{{ $section[$key]['label'] }}</a>
        @endif
    @endforeach
</section>
