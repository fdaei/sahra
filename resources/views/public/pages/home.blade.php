@php
    $hero = $sections['hero'] ?? null;
    $heroImage = $hero['image'] ?? null;
    $heroCtas = array_values(array_filter([$hero['primaryCta'] ?? null, $hero['secondaryCta'] ?? null]));
    $heroCtaSolid = 'flex items-center gap-1 whitespace-nowrap rounded-sm bg-ink px-4 py-[10px] text-[13px] font-medium text-paper transition-colors hover:bg-gold hover:text-white md:px-8 md:py-4 md:text-title-md';
    $heroCtaOutline = 'flex items-center gap-1 whitespace-nowrap rounded-sm border border-ink bg-paper px-4 py-[9px] text-[13px] font-medium text-ink transition-colors hover:border-gold hover:text-gold md:px-8 md:py-[15px] md:text-title-md';
    $kpi = $sections['kpi'] ?? null;
    $process = $sections['process'] ?? null;
    $packages = $sections['packages'] ?? null;
    $whyUs = $sections['why_us'] ?? null;
    $reviews = $sections['reviews'] ?? null;
    $insights = $sections['insights'] ?? null;
    $faqSection = $sections['faq'] ?? null;
    $defaultSubtitle = __('common.creative_decisions');
    $faqSubtitle = ($faqSection['subtitle'] ?? '') ?: $defaultSubtitle;
    $insightsSubtitle = ($insights['description'] ?? '') ?: (($insights['subtitle'] ?? '') ?: $defaultSubtitle);
    $whyUsIcons = ['badge-check', 'copy', 'gem', 'clipboard-check'];
    $kpiIcons = ['chart-no-axes-combined', 'trending-up', 'users-round'];
    $testimonialTrack = \App\Support\PublicPage::marquee($testimonials, 354);
@endphp

@if (!$hero)
    <h1 class="container-sahra pt-40 text-heading-xl">{{ $pageTitle }}</h1>
@endif

@if ($hero)
    <section class="relative min-h-[765px] overflow-hidden md:min-h-[904px]">
        @if ($heroImage)
            <img
                loading="eager"
                fetchpriority="high"
                class="absolute inset-0 size-full object-cover"
                src="{{ $heroImage['src'] }}"
                alt="{{ $heroImage['alt'] }}"
                width="{{ $heroImage['width'] }}"
                height="{{ $heroImage['height'] }}"
            >
        @else
            <picture class="absolute inset-0 rtl:-scale-x-100" aria-hidden="true">
                <source media="(min-width: 768px)" srcset="/images/sahra/hero-brand-preview-1024.webp">
                <img src="/images/sahra/hero-brand-preview-mobile.webp" alt=""
                     width="1024" height="704" class="size-full object-fill" fetchpriority="high">
            </picture>
        @endif
        <div class="mx-auto w-full max-w-frame">
            <div
                class="relative z-10 flex w-[731px] max-w-full flex-col gap-12 px-5 pb-10 pt-36 md:ms-24 md:max-w-[calc(100%-3rem)] md:gap-14 md:px-0 md:pb-0 md:pt-[176px]"
               
            >
                <div class="flex w-fit items-center gap-2 rounded-round bg-gold-100 p-2">
                    <span class="inline-block size-2 rotate-45 bg-gold-700" aria-hidden="true"></span>
                    <span class="text-label-md text-neutral-800" style="color: {{ ($hero['colors']['eyebrow'] ?: null) }};">{{ $hero['eyebrow'] }}</span>
                </div>
                <div class="flex flex-col gap-8 md:gap-12">
                    <h1
                        class="text-[28px] font-medium leading-normal tracking-[-0.02em] text-neutral-900 md:text-[48px] md:leading-[80px] md:tracking-[-0.05em]"
                        style="color: {{ ($hero['colors']['title'] ?: null) }};"
                    >
                        <span class="block text-[28px] md:text-[56px]">{{ $hero['title'] }}</span>
                        <span
                            class="block w-fit font-display text-[36px] leading-normal tracking-normal md:text-[96px] md:leading-[80px]"
                            style="color: {{ ($hero['colors']['content'] ?: 'var(--primary-gold, #BD933B)') }};"
                        >
                            {{ strip_tags($hero['content']) }}
                        </span>
                        <span class="block text-[28px] md:text-[56px]">{{ $hero['description'] }}</span>
                    </h1>
                    <p
                        class="w-full max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-[18px]"
                        style="color: {{ ($hero['colors']['subtitle'] ?: null) }};"
                    >
                        {{ $hero['subtitle'] }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2 md:gap-[10px]">
                    @foreach ($heroCtas as $i => $cta)
                        <a class="group {{ \Illuminate\Support\Arr::toCssClasses((($i === 0) ? $heroCtaSolid : $heroCtaOutline)) }}" href="{{ $cta['url'] }}">
                            {{ $cta['label'] }}
                            @includeIsolated('public.components.button-icon', ['name' => $cta['icon'], 'hoverName' => $cta['hoverIcon']])
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@if ($kpi)
    <section class="relative z-20 -mt-[117px] py-0 md:mt-0 md:py-24 lg:-mt-[54px] lg:py-28 lg:pt-0">
        <div class="container-sahra grid grid-cols-3 gap-2 text-center md:container-narrow md:gap-4" data-reveal-group>
            @foreach ($kpi['items'] as $i => $item)
                <div
                    class="group edge-gold flex h-[77px] flex-col items-center justify-center gap-2 rounded-[4px] px-3 py-3 md:h-auto md:px-3 md:py-6"
                    data-reveal
                >
                    <div class="flex items-center justify-center gap-1 md:gap-4">
                        @if (\App\Support\IconUrl::isImage($item['icon']))
                            @includeIsolated('public.components.hover-icon', ['class' => 'size-4 md:size-8', 'name' => $item['icon'], 'hoverName' => $item['hoverIcon']])
                        @else
                            @includeIsolated('public.icon', ['icon' => ($kpiIcons[$i] ?? 'trending-up'), 'class' => 'size-4 text-gold md:size-8', 'strokeWidth' => 1.5])
                        @endif
                        <p class="latin-nums text-[18px] font-medium leading-none text-ink md:text-[32px]">{{ $item['value'] }}</p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <p class="whitespace-nowrap text-[12px] font-medium leading-normal text-gold md:text-title-sm">{{ $item['title'] }}</p>
                        <p class="hidden text-body-md text-neutral-700 md:block">{{ $item['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
@if (!empty($sections['trust_proof']) || $clients)
<section class="section pb-[92px] pt-[88px] md:pb-24 md:pt-0 lg:mt-[19px] lg:pb-28">
    <div class="container-narrow flex flex-col gap-8">
        <h2 class="text-center text-[16px] font-medium leading-normal text-neutral-600 md:text-[22px]">
            {{ ($sections['trust_proof']['title'] ?? null) }}
            <span class="text-[20px] leading-normal text-neutral-900 md:text-[28px]">{{ strip_tags($sections['trust_proof']['content'] ?? '') }}</span>
            {{ ($sections['trust_proof']['subtitle'] ?? null) }}
        </h2>
        <div class="marquee-mask overflow-hidden">
            <div class="marquee-track items-center gap-12" style="--marquee-duration: 28s">
                @foreach (range(1, 2) as $copy)
                    @foreach ($clients as $i => $client)
                        <span class="group flex size-32 shrink-0 items-center justify-center" aria-hidden="{{ (($copy === 2) ? 'true' : null) }}">
                            <img
                                class="size-full object-contain p-2 grayscale transition-[filter] duration-300 ease-out group-hover:grayscale-0 group-focus-within:grayscale-0"
                                src="{{ $client['logo'] }}"
                                alt="{{ (($copy === 2) ? '' : $client['name']) }}"
                            >
                        </span>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@if (!empty($sections['services_cloud']))
    @include('public.components.services.services-orbit', ['class' => 'lg:mt-[23px]', 'section' => $sections['services_cloud'], 'services' => $services])
@endif
@if (!empty($sections['lead_magnet']))
    @include('public.components.sections.lead-magnet', ['class' => 'lg:mt-[48px]', 'mobileOffcanvas' => true, 'section' => $sections['lead_magnet']])
@endif
@if (!empty($sections['projects_showcase']))
    @include('public.components.sections.projects-showcase', ['class' => 'max-md:min-h-[971px] lg:-mt-[64px]', 'section' => $sections['projects_showcase'], 'projects' => $projects])
@endif
@if ($process)
    @include('public.components.sections.process-section', ['class' => 'max-md:!h-[944px] lg:mt-[7px]', 'section' => $process])
@endif
@if ($packages)
    @include('public.components.sections.packages-section', ['class' => 'max-md:mt-[80px] lg:mt-[126px]', 'section' => $packages])
@endif
@if ($whyUs)
    <section class="py-14 md:py-24 lg:mt-[92px] lg:py-28">
        <div class="container-sahra">
            <div class="eyebrow" style="color: {{ ($whyUs['colors']['eyebrow'] ?: null) }};">{{ $whyUs['eyebrow'] }}</div>
            <div class="mt-6 grid gap-12 lg:mt-8 lg:grid-cols-[506px_1fr] lg:items-center lg:justify-between lg:gap-8">
                <div class="flex flex-col gap-6 md:gap-10">
                    <h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="color: {{ ($whyUs['colors']['title'] ?: null) }};">
                        {{ $whyUs['title'] }}
                    </h2>
                    <p
                        class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
                        style="color: {{ ($whyUs['colors']['subtitle'] ?: null) }};"
                    >
                        {{ $whyUs['subtitle'] }}
                    </p>
                </div>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 md:gap-x-10 md:gap-y-12" data-reveal-group>
                    @foreach ($whyUs['items'] as $i => $item)
                        <div
                            class="group flex min-h-[140px] flex-col items-start gap-3 rounded-sm border border-gold-200 bg-gold-100 p-6 shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:gap-4 md:p-8"
                            data-reveal
                        >
                            @if (\App\Support\IconUrl::isImage($item['icon']))
                                @includeIsolated('public.components.hover-icon', ['class' => 'size-6 md:size-8', 'name' => $item['icon'], 'hoverName' => $item['hoverIcon']])
                            @elseif ((mb_strtolower(trim($item['title'])) === 'end-to-end support'))
                                <svg
                                    class="size-6 md:size-8"
                                    viewBox="0 0 10 10"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M1 1V6.33333C1 7.04058 1.28095 7.71885 1.78105 8.21895C2.28115 8.71905 2.95942 9 3.66667 9H9"
                                        stroke="#BD933B"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                     />
                                </svg>
                            @else
                                @includeIsolated('public.icon', ['icon' => ($whyUsIcons[$i] ?? 'badge-check'), 'class' => 'size-6 text-gold md:size-8', 'strokeWidth' => 1.5])
                            @endif
                            <div class="flex flex-col gap-2">
                                <h3 class="text-[16px] font-medium text-neutral-900 md:text-title-md">{{ $item['title'] }}</h3>
                                <p class="max-w-[212px] text-[12px] leading-normal text-neutral-600 md:text-body-lg">{{ $item['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@if ($reviews)
    <section class="h-auto overflow-visible py-14 md:h-auto md:py-24 lg:-mt-[100px] lg:py-28">
        <div class="container-sahra">
            <div class="eyebrow" style="color: {{ ($reviews['colors']['eyebrow'] ?: null) }};">{{ $reviews['eyebrow'] }}</div>
            <div class="mt-8 grid items-start gap-6 md:mt-12 lg:grid-cols-[505px_1fr] lg:gap-[132px]">
                <h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="color: {{ ($reviews['colors']['title'] ?: null) }};">
                    {{ $reviews['title'] }}
                </h2>
                @if ($reviews['subtitle'])
                    <p
                        class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
                        style="color: {{ ($reviews['colors']['subtitle'] ?: null) }};"
                    >
                        {{ $reviews['subtitle'] }}
                    </p>
                @endif
            </div>
        </div>
        <div class="container-sahra mt-10 md:mt-10">
            <div class="marquee-mask hidden h-[246px] overflow-hidden md:block md:h-[297px]">
                <div class="marquee-track h-full items-center gap-[26px]" style="--marquee-duration: 40s">
                    @foreach ($testimonialTrack as $i => $t)
                        <div
                            class="testimonial-card flex h-[220px] w-[328px] shrink-0 flex-col rounded-sm border-[0.5px] p-5 shadow-testimonial md:h-[246px] md:p-6"
                            aria-hidden="{{ (($i >= count($testimonials)) ? 'true' : null) }}"
                        >
                            <p class="text-body-md leading-normal text-neutral-800">{{ $t['quote'] }}</p>
                            <div class="mt-auto flex items-center gap-2">
                                @if ($t['avatar'])
                                    <img loading="lazy" decoding="async" width="48" height="48" class="size-12 rounded-full object-cover" src="{{ $t['avatar']['src'] }}" alt="{{ $t['avatar']['alt'] }}">
                                @endif
                                <div>
                                    <p class="text-label-lg text-neutral-700">{{ $t['name'] }}</p>
                                    <p class="mt-1 text-label-md text-neutral-600">{{ $t['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if (count($testimonials))
                <div class="md:hidden">
                    <div class="testimonial-rail -mx-5 flex snap-x snap-mandatory gap-4 overflow-x-auto px-5 py-2" data-ref="testimonialRail">
                        @foreach ($testimonials as $i => $t)
                            <div class="testimonial-card flex h-[246px] w-full shrink-0 snap-center flex-col rounded-sm border-[0.5px] p-6 shadow-testimonial">
                                <p class="text-[14px] leading-normal text-neutral-800">{{ $t['quote'] }}</p>
                                <div class="mt-auto flex items-center gap-2">
                                    @if ($t['avatar'])
                                        <img loading="lazy" decoding="async" width="48" height="48" class="size-12 rounded-full object-cover" src="{{ $t['avatar']['src'] }}" alt="{{ $t['avatar']['alt'] }}">
                                    @endif
                                    <div>
                                        <p class="text-label-lg text-neutral-700">{{ $t['name'] }}</p>
                                        <p class="mt-1 text-label-md text-neutral-600">{{ $t['role'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (count($testimonials))
                        <div class="mt-6 flex h-[10px] items-center justify-center gap-2">
                            @foreach ($testimonials as $i => $_)
                                <button
                                    type="button"
                                    class="size-[10px] rounded-full transition-colors duration-300 {{ \Illuminate\Support\Arr::toCssClasses((($i === 0) ? 'bg-gold-600' : 'bg-neutral-200')) }}"
                                    aria-label="{{ (($i + 1) . ' / ' . count($testimonials)) }}"
                                    @if ((($i === 0) ? 'true' : null)) aria-current="{{ (($i === 0) ? 'true' : null) }}" @endif
                                    data-action="goToTestimonial"
                                    data-index="{{ $i }}"
                                ></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endif
@if ($insights)
    <section class="py-14 md:py-24 lg:-mt-[10px] lg:py-28">
        <div class="container-sahra flex flex-col gap-10 md:gap-12">
            <div class="flex flex-col gap-8 md:gap-12">
                <div class="eyebrow" style="color: {{ ($insights['colors']['eyebrow'] ?: null) }};">{{ $insights['eyebrow'] }}</div>
                <div class="grid items-start gap-8 lg:grid-cols-[505px_1fr] lg:gap-[132px]">
                    <h2
                        class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-display-md"
                        style="color: {{ ($insights['colors']['title'] ?: null) }};"
                    >
                        {{ $insights['title'] }}
                    </h2>
                    @if ($insightsSubtitle)
                        <p
                            class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
                            style="color: {{ (($insights['colors']['description'] ?: $insights['colors']['subtitle']) ?: null) }};"
                        >
                            {{ $insightsSubtitle }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="grid gap-6 lg:h-[424px] lg:grid-cols-2" data-reveal-group>
                @if (($posts[0] ?? null))
                    <a
                        class="group flex min-h-[457px] flex-col gap-6 overflow-hidden rounded-sm bg-[#fbf9f5] p-4 shadow-card md:grid md:h-auto md:min-h-0 md:grid-cols-[279px_270px] md:justify-between md:gap-0"
                        data-reveal
                        href="{{ ($posts[0]['url'] ?? null) }}"
                    >
                        <div class="h-[248px] overflow-hidden rounded-sm border border-neutral-100 shadow-card md:h-[392px]">
                            @if (($posts[0]['image'] ?? null))
                                <img
                                    loading="lazy"
                                    decoding="async"
                                    class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]"
                                    src="{{ ($posts[0]['image']['src'] ?? null) }}"
                                    alt="{{ ($posts[0]['image']['alt'] ?? null) }}"
                                >
                            @endif
                        </div>
                        <div class="flex min-w-0 flex-1 flex-col gap-6 md:justify-between md:gap-0 md:py-0">
                            <div class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md">
                                @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-4 text-gold md:size-6', 'strokeWidth' => 1.5])
                                <span>{{ ($posts[0]['publishedAt'] ?? null) }}</span>
                            </div>
                            <h3 class="text-[16px] font-semibold leading-normal text-gold md:text-title-md">{{ ($posts[0]['title'] ?? null) }}</h3>
                            <p class="text-[13px] leading-normal text-neutral-700 md:text-body-md">{{ ($posts[0]['excerpt'] ?? null) }}</p>
                            <span
                                class="ms-auto hidden size-10 items-center justify-center rounded-round border border-neutral-800 bg-ink text-paper transition-colors group-hover:border-transparent group-hover:bg-gold group-hover:text-white md:flex md:size-12"
                            >
                                @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-8 rtl:-scale-x-100', 'strokeWidth' => 1.25])
                            </span>
                        </div>
                    </a>
                @endif
                <div class="flex flex-col gap-3 md:gap-6" data-reveal>
                    @foreach (array_slice($posts, 1, 3 - 1) as $index => $post)
                        <a
                            class="group grid h-[120px] grid-cols-[120px_1fr] gap-4 md:h-auto md:flex-1 md:gap-6 sm:grid-cols-[188px_1fr] {{ \Illuminate\Support\Arr::toCssClasses((($index === 0) ? 'border-b border-neutral-200 pb-[9.25rem] md:pb-6' : 'pt-8 md:pt-6')) }}"
                            href="{{ $post['url'] }}"
                        >
                            <div class="aspect-square size-[120px] overflow-hidden rounded-sm md:size-[188px]">
                                @if ($post['image'])
                                    <img loading="lazy" decoding="async"
                                        class="h-full w-full object-cover transition-transform duration-400 ease-brand group-hover:scale-[1.04]"
                                        src="{{ $post['image']['src'] }}"
                                        alt="{{ $post['image']['alt'] }}"
                                    >
                                @endif
                            </div>
                            <div class="flex flex-col justify-center gap-3 md:gap-6">
                                <div class="flex items-center gap-2 text-[12px] leading-normal text-neutral-700 md:text-body-md">
                                    @includeIsolated('public.icon', ['icon' => 'calendar-days', 'class' => 'size-4 text-gold md:size-6', 'strokeWidth' => 1.5])
                                    <span>{{ $post['publishedAt'] }}</span>
                                </div>
                                <h3 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-title-md">{{ $post['title'] }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@if ($faqSection)
    <section class="py-14 md:py-24 lg:-mt-[98px] lg:py-28">
        <div class="container-sahra">
            <div class="eyebrow" style="color: {{ ($faqSection['colors']['eyebrow'] ?: null) }};">{{ $faqSection['eyebrow'] }}</div>
            <div class="mt-8 grid gap-8 md:mt-12 lg:grid-cols-[497px_1fr]">
                <div class="flex flex-col justify-between gap-8">
                    <h2 class="text-[26px] font-semibold leading-normal md:text-display-md" style="color: {{ ($faqSection['colors']['title'] ?: null) }};">
                        {{ $faqSection['title'] }}
                    </h2>
                    @if ($faqSubtitle)
                        <p
                            class="text-[16px] font-medium leading-normal text-neutral-700 md:text-title-sm"
                            style="color: {{ ($faqSection['colors']['subtitle'] ?: null) }};"
                        >
                            {{ $faqSubtitle }}
                        </p>
                    @endif
                </div>
                <div class="flex flex-col gap-3 md:gap-6" data-reveal-group>
                    @foreach ($faqs as $i => $faq)
                        <details
                            name="faq-accordion"
                            class="group rounded-sm border border-gold-200 bg-gold-100 p-4 md:p-8"
                            data-reveal
                            @open(($i === 1))
                        >
                            <summary
                                class="flex cursor-pointer list-none items-center justify-between gap-4 text-[14px] font-medium text-neutral-900 md:text-title-sm [&::-webkit-details-marker]:hidden"
                            >
                                {{ $faq['question'] }}
                                <!--
                Figma 438:571 / 438:551 export as a ringed glyph — a 20px
                circle at stroke 1.5 #4F4C4D with the bar(s) inside it, i.e.
                lucide `circle-plus` / `circle-minus`. The bare `plus` / `minus`
                used here before dropped that ring, which is the "+ has no
                border" defect. Colour is black/800 (#4F4C4D), matching the
                exported stroke exactly — not black/700.
              -->
                                <span class="relative size-6 shrink-0 text-neutral-800">
                                    @includeIsolated('public.icon', ['icon' => 'circle-plus', 'class' => 'absolute inset-0 size-6 group-open:hidden', 'strokeWidth' => 1.5])
                                    @includeIsolated('public.icon', ['icon' => 'circle-minus', 'class' => 'absolute inset-0 hidden size-6 group-open:block', 'strokeWidth' => 1.5])
                                </span>
                            </summary>
                            <p class="mt-3 text-[12px] leading-normal text-neutral-700 md:mt-4 md:text-body-lg">{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@if (!empty($sections['final_cta']))
    @include('public.components.cta-banner', ['class' => 'lg:mb-[61px] lg:mt-[82px]', 'spacingClass' => 'pb-[182px] pt-24 md:pb-[260px]', 'section' => $sections['final_cta']])
@endif
