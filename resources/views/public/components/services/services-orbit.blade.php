@php
    $activePositions = [[50, 27], [35, 39], [65, 39], [31, 53], [50, 53], [38, 68], [64, 68]];
    $brandPositions = [['x' => 18, 'y' => 23], ['x' => 11, 'y' => 38], ['x' => 14, 'y' => 64], ['x' => 21, 'y' => 79]];
    $productPositions = [['x' => 82, 'y' => 21], ['x' => 90, 'y' => 36], ['x' => 86, 'y' => 61], ['x' => 80, 'y' => 76], ['x' => 88, 'y' => 87]];
    $accents = ['var(--color-gold)', 'var(--color-gold-900)', 'var(--color-gold-600)', 'var(--color-gold-500)'];
    $groups = collect($services)->groupBy('homeOrbitGroup');
    $brandGhosts = $groups->get('brand', collect())->all();
    $productGhosts = $groups->get('product', collect())->all();
    $cards = $groups->get('active', collect())->map(function ($service, $index) use ($activePositions, $accents) {
        [$x, $y] = $activePositions[$index % count($activePositions)];
        return [
            ...$service,
            'displayTitle' => $service['title'],
            'href' => $service['externalUrl'] ?: route('services', absolute: false).'#'.rawurlencode($service['slug']),
            'accent' => $accents[$index % count($accents)],
            'position' => ['x' => $x, 'y' => $y],
        ];
    })->all();
    $leftAxisLabel = __('services.axis_left');
    $rightAxisLabel = __('services.axis_right');
@endphp

<section class="services-cloud is-visible {{ $class ?? '' }}">
    <div class="container-sahra relative z-10 py-12 md:py-20 lg:py-24">
        <div class="flex flex-col gap-6 lg:gap-12">
            <div class="service-eyebrow">
                <span aria-hidden="true"></span>
                {{ ($section['eyebrow'] ?: __('services.eyebrow')) }}
            </div>
            <div class="grid gap-4 lg:grid-cols-[506px_1fr] lg:gap-[130px]">
                <h2 class="max-w-[506px] text-[28px] font-semibold leading-normal text-white md:text-[36px] lg:text-[40px] lg:leading-[1.5]">
                    {{ $section['title'] }}
                </h2>
                <p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-200 md:text-[18px]">{{ $section['description'] }}</p>
            </div>
        </div>
        <div class="cloud-diagram" role="group" aria-label="{{ __('services.orbit_label') }}">
            @include('public.components.services.mastery-diagram', ['leftLabel' => $leftAxisLabel, 'rightLabel' => $rightAxisLabel, 'coreLabel' => ($section['orbitCoreLabel'] ?: __('services.core'))])
            <div class="services-grid">
                <div class="side-col side-col--brand" aria-hidden="true">
                    @foreach ($brandGhosts as $index => $service)
                        <div
                            class="ghost-service {{ \Illuminate\Support\Arr::toCssClasses(['ghost-service--no-image' => !$service['image']]) }}"
                            style="--x: {{ ($brandPositions[($index % count($brandPositions))]['x'] . '%') }}; --y: {{ ($brandPositions[($index % count($brandPositions))]['y'] . '%') }};"
                        >
                            <strong>{{ $service['title'] }}</strong>
                        </div>
                    @endforeach
                </div>
                <div class="mastery-col">
                    @foreach ($cards as $index => $service)
                        <article
                            class="service-card {{ \Illuminate\Support\Arr::toCssClasses(['service-card--has-image' => !!$service['image']]) }}"
                            style="--accent: {{ $service['accent'] }}; --x: {{ ($service['position']['x'] . '%') }}; --y: {{ ($service['position']['y'] . '%') }}; --delay: {{ (($index * 70) . 'ms') }};"
                        >
                            @if ($service['image'])
                                <div class="service-card__content" aria-hidden="true">
                                    <div class="service-card__asset">
                                        <img
                                            alt=""
                                            loading="lazy"
                                            decoding="async"
                                            src="{{ $service['image']['src'] }}"
                                        >
                                    </div>
                                </div>
                            @endif
                            <a class="service-card__title group" href="{{ $service['href'] }}">
                                @if (($service['icon'] || $service['hoverIcon']))
                                    <span class="service-card__icon service-card__icon--asset" aria-hidden="true">
                                        @includeIsolated('public.components.button-icon', ['class' => 'size-full', 'name' => $service['icon'], 'hoverName' => $service['hoverIcon']])
                                    </span>
                                @else
                                    <span class="service-card__icon" aria-hidden="true"></span>
                                @endif
                                <strong>{{ $service['displayTitle'] }}</strong>
                                <svg
                                    class="service-card__arrow"
                                    width="12"
                                    height="12"
                                    viewBox="0 0 11 12"
                                    fill="none"
                                    aria-hidden="true"
                                >
                                    <path d="M7.69 4.812 4.022 1.143 5.083.083l5.48 5.48-5.48 5.48-1.06-1.06 3.67-3.67H.188v-1.5H7.69Z" fill="currentColor" />
                                </svg>
                            </a>
                        </article>
                    @endforeach
                </div>
                <div class="side-col side-col--product" aria-hidden="true">
                    @foreach ($productGhosts as $index => $service)
                        <div
                            class="ghost-service {{ \Illuminate\Support\Arr::toCssClasses(['ghost-service--no-image' => !$service['image']]) }}"
                            style="--x: {{ ($productPositions[($index % count($productPositions))]['x'] . '%') }}; --y: {{ ($productPositions[($index % count($productPositions))]['y'] . '%') }};"
                        >
                            <strong>{{ $service['title'] }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
