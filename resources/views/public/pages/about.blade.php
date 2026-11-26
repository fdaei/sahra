@php
    $hero = $sections['about_hero'] ?? null;
    $heroImage = $hero['image'] ?? null;
    $story = $sections['story'] ?? null;
    $howWeThink = $sections['how_we_think'] ?? null;
    $thinkIcons = ['badge-check', 'focus', 'repeat2', 'trending-up'];
    $members = $team;
    $team = $sections['team'] ?? null;
    $teamRows = [];
    foreach (array_chunk($members, max(1, (int) ceil(count($members) / 2))) as $row) {
        $teamRows[] = ['items' => \App\Support\PublicPage::marquee($row, 254), 'uniqueCount' => count($row)];
    }
@endphp

@if (!$hero)
    <h1 class="container-sahra pt-40 text-heading-xl">{{ $pageTitle }}</h1>
@endif

<section class="relative overflow-hidden pb-0 pt-[139px] md:pb-[128px] md:pt-[192px]">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="relative mx-auto h-full w-full max-w-frame">
            <img
                alt=""
                width="1500"
                height="1320"
                class="absolute -top-[506px] start-[672px] w-[1500px] max-w-none"
                src="{{ Vite::asset('resources/images/decor/arc-rings.svg') }}"
            >
        </div>
    </div>
    <div class="container-sahra relative flex flex-col gap-0 lg:gap-[200px]">
        @if ($hero)
            <div
                class="grid h-[340px] grid-cols-[1fr_151px] items-start gap-[14px] lg:flex lg:h-auto lg:flex-row lg:items-center lg:justify-between lg:gap-[100px] xl:gap-[250px]"
            >
                <div class="flex w-full flex-col gap-12 lg:max-w-[506px]">
                    <p class="eyebrow" style="color: {{ ($hero['colors']['eyebrow'] ?: null) }};">{{ $hero['eyebrow'] }}</p>
                    <div class="flex flex-col gap-6">
                        <h1 style="color: {{ ($hero['colors']['title'] ?: null) }};">
                            <span class="block font-display text-[32px] font-normal leading-none tracking-[-0.01em] text-gold md:text-[76px]">
                                {{ $hero['title'] }}
                            </span>
                            @if ($hero['content'])
                                <span
                                    class="mt-2 block text-[22px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[40px]"
                                    style="color: {{ ($hero['colors']['content'] ?: null) }};"
                                >
                                    {{ strip_tags($hero['content']) }}
                                </span>
                            @endif
                        </h1>
                        <p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="color: {{ ($hero['colors']['description'] ?: null) }};">
                            {{ $hero['description'] }}
                        </p>
                    </div>
                </div>
                <img
                    width="321"
                    height="405"
                    loading="eager"
                    fetchpriority="high"
                    class="w-[151px] shrink-0 object-contain lg:w-[321px]"
                    src="{{ $heroImage['src'] ?? '/images/sahra/about-hero-sculpture-320.webp' }}"
                    @unless ($heroImage)
                        srcset="/images/sahra/about-hero-sculpture-320.webp 320w, /images/sahra/about-hero-sculpture-642.webp 642w"
                        sizes="(min-width: 1024px) 321px, 151px"
                    @endunless
                    alt="{{ $heroImage['alt'] ?? '' }}"
                    aria-hidden="{{ ($heroImage ? null : 'true') }}"
                >
            </div>
        @endif
        @if ($story)
            <div class="mt-[115px] flex h-[313px] flex-col gap-8 lg:mt-0 lg:h-auto lg:flex-row lg:justify-between lg:gap-[166px]">
                <h2
                    class="text-[22px] font-semibold leading-normal text-neutral-900 md:text-display-md lg:max-w-[472px] lg:shrink-0"
                    style="color: {{ ($story['colors']['title'] ?: null) }};"
                >
                    {{ $story['title'] }}
                </h2>
                <div class="flex flex-col gap-6 lg:max-w-[612px]">
                    <p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="color: {{ ($story['colors']['description'] ?: null) }};">
                        {{ $story['description'] }}
                    </p>
                    @if ($story['content'])
                        <p class="text-body-md text-neutral-700 md:text-title-sm md:font-medium" style="color: {{ ($story['colors']['content'] ?: null) }};">
                            {{ strip_tags($story['content']) }}
                        </p>
                    @endif
                </div>
            </div>
        @endif
        @if ($howWeThink)
            <div class="mt-[81px] flex h-[759px] flex-col gap-[51px] md:gap-12 lg:mt-0 lg:h-auto">
                <div class="flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[348px]">
                    <h2 class="text-[22px] font-semibold md:text-display-md lg:shrink-0" style="color: {{ ($howWeThink['colors']['title'] ?: null) }};">
                        {{ $howWeThink['title'] }}
                    </h2>
                    <p
                        class="hidden text-body-md text-neutral-700 md:block md:text-title-sm md:font-medium lg:max-w-[612px]"
                        style="color: {{ ($howWeThink['colors']['description'] ?: null) }};"
                    >
                        {{ $howWeThink['description'] }}
                    </p>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($howWeThink['items'] as $i => $item)
                        <div
                            class="group flex flex-col gap-4 rounded-sm border-x border-b border-t-[3px] border-gold-400 border-t-gold bg-neutral-50/30 p-6 md:gap-6 md:py-12"
                        >
                            @if (\App\Support\IconUrl::isImage($item['icon']))
                                @includeIsolated('public.components.hover-icon', ['class' => 'size-5 md:size-8', 'name' => $item['icon'], 'hoverName' => $item['hoverIcon']])
                            @else
                                @includeIsolated('public.icon', ['icon' => ($thinkIcons[$i] ?? 'trending-up'), 'class' => 'size-5 shrink-0 text-gold md:size-8', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                            @endif
                            <div class="flex flex-col gap-2">
                                <h3 class="text-[18px] font-medium text-neutral-900 md:text-title-xl">{{ $item['title'] }}</h3>
                                <p class="text-[14px] text-neutral-800 md:text-title-sm">{{ $item['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if ($team)
            <div class="relative isolate mt-[98px] flex flex-col gap-12 md:gap-24 lg:mt-0">
                <img
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    width="1160"
                    height="1000"
                    class="pointer-events-none absolute -top-[104px] start-[37px] z-0 hidden w-[1160px] max-w-none opacity-100 lg:block"
                    src="{{ Vite::asset('resources/images/decor/dune-contours.webp') }}"
                >
                <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:justify-between lg:gap-[328px]">
                    <h2
                        class="max-w-[287px] text-[22px] font-semibold leading-normal [text-wrap:initial] md:text-display-md lg:shrink-0"
                        style="color: {{ ($team['colors']['title'] ?: null) }};"
                    >
                        {{ $team['title'] }}
                    </h2>
                    <p class="hidden text-title-xl text-neutral-800 md:block lg:max-w-[612px]" style="color: {{ ($team['colors']['description'] ?: null) }};">
                        {{ $team['description'] }}
                    </p>
                </div>
                <div class="team-mobile-viewport relative z-10 lg:hidden" data-team-rail tabindex="0" aria-label="{{ $team['title'] }}">
                    <div class="team-mobile-track gap-4">
                        @foreach ($members as $member)
                            <figure
                                class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60"
                            >
                                @if ($member['image'])
                                    <div class="aspect-square w-full overflow-hidden rounded-sm">
                                        <img
                                            draggable="false" loading="lazy" decoding="async"
                                            class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"
                                            src="{{ $member['image']['src'] }}"
                                            alt="{{ $member['image']['alt'] }}"
                                            width="{{ $member['image']['width'] }}"
                                            height="{{ $member['image']['height'] }}"
                                        >
                                    </div>
                                @else
                                    <div class="aspect-square w-full rounded-sm bg-neutral-100"></div>
                                @endif
                                <figcaption class="flex flex-col gap-1 px-3 py-2">
                                    <p class="text-[14px] font-medium text-neutral-900">{{ $member['name'] }}</p>
                                    <p class="text-[12px] text-neutral-600">{{ $member['role'] }}</p>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
                <div class="relative z-10 hidden flex-col gap-[26px] lg:flex">
                    @foreach ($teamRows as $rowIndex => $row)
                        <div class="marquee-mask overflow-hidden">
                            <div
                                class="marquee-track gap-4 md:gap-6 lg:gap-[26px] {{ \Illuminate\Support\Arr::toCssClasses(((($rowIndex % 2) === 0) ? 'marquee-track--reverse' : '')) }}"
                                style="--marquee-duration: {{ ((($rowIndex % 2) === 0) ? '90s' : '100s') }};"
                            >
                                @foreach ($row['items'] as $i => $member)
                                    <figure
                                        class="flex w-[174px] shrink-0 flex-col gap-2 overflow-hidden rounded-sm border border-neutral-200 bg-paper/60 lg:w-[228px]"
                                        aria-hidden="{{ (($i >= $row['uniqueCount']) ? 'true' : null) }}"
                                    >
                                        @if ($member['image'])
                                            <div class="aspect-square w-full overflow-hidden rounded-sm">
                                                <img
                                                    class="size-full object-cover grayscale transition-[filter,transform] duration-500 ease-brand hover:scale-[1.06] hover:grayscale-0 focus-visible:scale-[1.06] focus-visible:grayscale-0 motion-reduce:transition-none"
                                                    src="{{ $member['image']['src'] }}"
                                                    alt="{{ (($i >= $row['uniqueCount']) ? '' : $member['image']['alt']) }}"
                                                    width="{{ $member['image']['width'] }}"
                                                    height="{{ $member['image']['height'] }}"
                                                >
                                            </div>
                                        @else
                                            <div class="aspect-square w-full rounded-sm bg-neutral-100"></div>
                                        @endif
                                        <figcaption class="flex flex-col gap-1 px-3 py-2 md:px-4">
                                            <p class="text-[14px] font-medium text-neutral-900 md:text-title-lg">{{ $member['name'] }}</p>
                                            <p class="text-[12px] text-neutral-600 md:text-title-sm">{{ $member['role'] }}</p>
                                        </figcaption>
                                    </figure>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@if (!empty($sections['final_cta']))
    @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $sections['final_cta']])
@endif
