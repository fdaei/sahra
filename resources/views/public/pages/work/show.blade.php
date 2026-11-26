@php
    $info = array_values(array_filter([
        ['icon' => 'building2', 'label' => __('work.industry'), 'value' => $project['industry']],
        ['icon' => 'calendar-days', 'label' => __('work.year'), 'value' => $project['year']],
        ['icon' => 'instagram', 'label' => __('work.instagram'), 'value' => $project['instagram'],
            'href' => $project['instagram'] ? 'https://instagram.com/'.rawurlencode($project['instagram']) : null],
        ['icon' => 'layout-grid', 'label' => __('work.services'), 'value' => implode(', ', $project['services'])],
    ], fn ($row) => filled($row['value'])));
    $resultIcons = [
        '/icons/sahra/results/roi.svg',
        '/icons/sahra/results/reach.svg',
        '/icons/sahra/results/interaction.svg',
        '/icons/sahra/results/follower.svg',
        '/icons/sahra/results/view.svg',
    ];
    $showcaseLabels = [__('work.type_post'), __('work.type_story'), __('work.type_logo')];
    $showcaseFilters = array_map(fn ($image, $index) => $showcaseLabels[$index] ?? ($image['alt'] ?: (string) ($index + 1)), $project['showcase'], array_keys($project['showcase']));
    $activeShowcaseIndex = 0;
@endphp

<div class="relative overflow-x-clip">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="relative mx-auto h-full w-full max-w-frame">
            <img
                alt=""
                width="1473"
                height="1563"
                class="absolute start-[-617px] top-[974px] w-[1473px] max-w-none max-md:start-[-760px] max-md:top-[820px]"
                src="{{ Vite::asset('resources/images/decor/arc-rings-project.svg') }}"
            >
        </div>
    </div>
    <div class="container-sahra relative z-10 flex flex-col gap-0 pb-0 pt-[160px] md:gap-[144px] md:pb-56 md:pt-[184px]">
        <div class="flex flex-col gap-0 md:gap-[200px]">
            <div class="flex flex-col gap-6 md:gap-20">
                <div class="flex flex-col gap-8 lg:flex-row lg:justify-between lg:gap-[342px]">
                    <div class="flex max-w-[612px] flex-col gap-4 md:gap-6">
                        <h1 class="text-[26px] font-semibold leading-normal text-neutral-900 md:text-[48px]">{{ $project['title'] }}</h1>
                        @if ($project['excerpt'])
                            <p class="text-[16px] font-normal leading-normal tracking-[-0.02em] text-neutral-700 md:text-[18px] md:font-medium md:tracking-normal">
                                {{ $project['excerpt'] }}
                            </p>
                        @endif
                    </div>
                    @if ((count($info) > 0))
                        <dl class="grid w-full shrink-0 grid-flow-col grid-cols-2 grid-rows-2 justify-between gap-y-4 md:flex md:w-auto md:flex-col md:gap-6">
                            @foreach ($info as $row)
                                <div class="flex flex-col gap-1">
                                    <dt class="flex items-center gap-2">
                                        @includeIsolated('public.icon', ['icon' => $row['icon'], 'class' => 'size-5 shrink-0 text-gold', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                        <span class="text-[14px] font-medium leading-[18px] text-neutral-1000 md:text-label-lg">{{ $row['label'] }}</span>
                                    </dt>
                                    <dd class="max-w-[220px] text-[14px] leading-[18px] text-neutral-800 md:text-body-md">
                                        @if (!empty($row['href']))
                                            <a
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="underline decoration-neutral-300 underline-offset-2 hover:text-gold"
                                                href="{{ $row['href'] }}"
                                            >
                                                {{ $row['value'] }}
                                            </a>
                                        @else
                                            {{ $row['value'] }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    @endif
                </div>
                @if ($project['banner'])
                    <img fetchpriority="high" decoding="async"
                        width="1248"
                        height="624"
                        class="h-[272px] w-full rounded-lg object-cover shadow-banner md:h-auto md:aspect-[1248/624]"
                        src="{{ $project['banner']['src'] }}"
                        alt="{{ $project['banner']['alt'] }}"
                    >
                @endif
            </div>
            @if ($project['challenge'])
                <section class="mt-8 flex min-h-[277px] flex-col gap-8 md:mt-0 md:min-h-0 md:gap-10 lg:flex-row lg:justify-between" data-reveal>
                    <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.challenge') }}</h2>
                    <div class="flex w-full max-w-[612px] flex-col gap-4 md:gap-6">
                        <p class="text-[18px] font-medium leading-normal text-ink md:text-[32px]">
                            &ldquo;
                            {{ $project['challenge'] }}
                            &rdquo;
                        </p>
                        @if ((count($project['challengePoints']) > 0))
                            <ul class="flex flex-col gap-2">
                                @foreach ($project['challengePoints'] as $i => $point)
                                    <li class="flex items-center gap-2 text-body-md text-neutral-800 md:text-[18px]">
                                        @includeIsolated('public.icon', ['icon' => 'move-right', 'class' => 'size-5 shrink-0 text-gold rtl:-scale-x-100', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                        {{ $point }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </section>
            @endif
            @if ((count($project['goals']) > 0))
                <section class="mt-[104px] flex flex-col gap-12 md:mt-0" data-reveal>
                    <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.goals') }}</h2>
                    <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($project['goals'] as $i => $card)
                            <li
                                class="flex flex-col gap-4 rounded-sm border-x border-b border-t-[3px] border-gold-400 border-t-gold bg-neutral-50/30 p-6 md:gap-6 md:py-12"
                            >
                                @includeIsolated('public.icon', ['icon' => 'badge-check', 'class' => 'size-6 shrink-0 text-gold md:hidden', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                                <span class="hidden font-medium leading-none text-gold md:block md:text-[36px]">
                                    {{ str_pad(((string) ($i + 1)), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="flex flex-col gap-2">
                                    <span class="text-[18px] font-medium text-neutral-900 md:text-[24px]">{{ $card['title'] }}</span>
                                    <span class="text-[14px] leading-normal text-neutral-800 md:text-[18px]">{{ $card['description'] }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </section>
            @endif
            @if ((count($project['strategy']) > 0))
                <section class="mt-[90px] flex flex-col gap-12 md:mt-0 md:gap-10 lg:flex-row lg:justify-between" data-reveal>
                    <h2 class="shrink-0 text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.strategy') }}</h2>
                    <ol class="grid w-full max-w-[860px] grid-cols-2">
                        @foreach ($project['strategy'] as $i => $card)
                            <li class="flex flex-col gap-4 border-gold-300 p-4 md:p-6 [&:nth-child(odd)]:border-e [&:nth-child(-n+2)]:border-b">
                                <span class="text-[18px] font-medium leading-normal text-gold">
                                    {{ str_pad(((string) ($i + 1)), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <h3 class="text-[16px] font-medium leading-normal text-gold md:text-[24px]">{{ $card['title'] }}</h3>
                                <p class="text-[14px] leading-normal text-neutral-700 md:text-[18px]">{{ $card['description'] }}</p>
                            </li>
                        @endforeach
                    </ol>
                </section>
            @endif
            @if ((count($project['deliverables']) > 0))
                <section class="mt-[111px] flex flex-col gap-12 md:mt-0" data-reveal>
                    <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.deliverables') }}</h2>
                    <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($project['deliverables'] as $i => $card)
                            <li
                                class="deliverables-card relative flex flex-col gap-8 overflow-hidden rounded-sm border border-gold-300 bg-paper p-6 shadow-[2px_2px_10px_rgba(0,0,0,0.05)] md:min-h-[306px] md:gap-12 md:py-6"
                            >
                                <img loading="lazy" decoding="async"
                                    alt=""
                                    class="deliverables-card__background pointer-events-none absolute max-w-none opacity-60"
                                    aria-hidden="true"
                                    src="/images/sahra/deliverables-card-bg-640.webp"
                                >
                                <span class="relative z-10 text-[22px] font-medium leading-none text-gold md:text-[36px] md:leading-normal">
                                    {{ str_pad(((string) ($i + 1)), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="relative z-10 flex flex-col gap-2">
                                    <span class="text-[18px] font-medium leading-normal text-neutral-900 md:text-[24px]">{{ $card['title'] }}</span>
                                    <span class="text-[14px] leading-normal text-neutral-800 md:text-[18px]">{{ $card['description'] }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </section>
            @endif
            @if ((count($project['showcase']) > 0))
                <section class="relative mt-[76px] h-[488px] md:mt-0 md:h-auto" data-reveal>
                    <div class="md:flex md:items-center md:justify-between">
                        <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.showcase') }}</h2>
                        <div
                            class="absolute inset-x-0 top-[79px] flex justify-center gap-16 text-[14px] leading-none md:static md:inset-auto md:shrink-0 md:justify-start"
                            role="tablist"
                            aria-label="{{ __('work.content_types') }}"
                        >
                            @foreach ($showcaseFilters as $index => $label)
                                @if (($index < count($project['showcase'])))
                                    <button
                                        type="button"
                                        role="tab"
                                        class="cursor-pointer whitespace-nowrap text-neutral-700 transition-colors {{ \Illuminate\Support\Arr::toCssClasses((($activeShowcaseIndex === $index) ? 'font-medium text-ink underline decoration-from-font underline-offset-2' : 'font-normal hover:text-ink')) }}"
                                        id="{{ ('showcase-tab-' . $index) }}"
                                        aria-controls="{{ ('showcase-panel-' . $index) }}"
                                        aria-selected="{{ (($activeShowcaseIndex === $index) ? 'true' : 'false') }}"
                                        tabindex="{{ (($activeShowcaseIndex === $index) ? 0 : -1) }}"
                                        data-action="selectShowcase"
                                        data-index="{{ $index }}"
                                    >
                                        {{ $label }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <ul class="absolute inset-x-0 top-[160px] md:static md:mt-12 md:grid md:grid-cols-2 md:gap-6 lg:grid-cols-3">
                        @foreach ($project['showcase'] as $i => $image)
                            <li
                                role="tabpanel"
                                class="w-[262px] md:w-auto" @if ($i !== 0) hidden @endif
                                id="{{ ('showcase-panel-' . $i) }}"
                                @if ((($i < count($showcaseFilters)) ? ('showcase-tab-' . $i) : null)) aria-labelledby="{{ (($i < count($showcaseFilters)) ? ('showcase-tab-' . $i) : null) }}" @endif
                            >
                                <img loading="lazy" decoding="async"
                                    width="400"
                                    height="500"
                                    class="h-[328px] w-full rounded-sm object-cover md:aspect-[4/5] md:h-auto"
                                    src="{{ $image['src'] }}"
                                    alt="{{ $image['alt'] }}"
                                >
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
            @if ($project['results'] || $project['resultsSummary'])
                <section class="mt-[76px] flex flex-col gap-0 md:mt-0 md:gap-12" data-reveal>
                    <h2 class="text-[22px] font-semibold text-neutral-900 md:text-[40px]">{{ __('work.results') }}</h2>
                    <ul class="mt-12 grid grid-cols-2 gap-3 md:mt-0 md:grid-cols-3 md:gap-6 lg:grid-cols-5">
                        @foreach ($project['results'] as $i => $stat)
                            <li class="group flex flex-col gap-4 rounded-sm bg-gold-100 px-6 py-4 md:px-8">
                                @if (\App\Support\IconUrl::isImage($stat['icon']))
                                    @includeIsolated('public.components.hover-icon', ['class' => 'size-8', 'name' => $stat['icon'], 'hoverName' => $stat['hoverIcon']])
                                @else
                                    <img
                                        alt=""
                                        class="size-8 object-contain object-left"
                                        aria-hidden="true"
                                        src="{{ $resultIcons[$i] ?? $resultIcons[0] }}"
                                    >
                                @endif
                                <span class="flex flex-col gap-2">
                                    <span class="text-[18px] font-medium leading-normal text-neutral-900 md:text-title-lg">{{ $stat['label'] }}</span>
                                    <span class="latin-nums text-[22px] font-medium leading-normal text-gold md:text-[30px] md:leading-none">
                                        {{ $stat['value'] }}
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    @if ($project['resultsSummary'])
                        <p class="mt-8 whitespace-pre-line text-[16px] leading-normal text-neutral-800 md:mt-0 md:text-[24px] md:font-medium">
                            {{ $project['resultsSummary'] }}
                        </p>
                    @endif
                </section>
            @endif
        </div>
        @if (($project['beforeAfter']['before'] || $project['beforeAfter']['after']))
            <section class="mt-[74px] grid gap-4 md:mt-0 md:gap-6 sm:grid-cols-2" data-reveal>
                @if ($project['beforeAfter']['before'])
                    <figure class="flex flex-col gap-3 md:gap-6">
                        <figcaption class="text-center text-[20px] font-medium text-neutral-900 md:text-[28px] md:font-semibold">
                            {{ __('work.before') }}
                        </figcaption>
                        <img loading="lazy" decoding="async"
                            class="h-[181px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:h-[306px]"
                            src="{{ $project['beforeAfter']['before']['src'] }}"
                            alt="{{ $project['beforeAfter']['before']['alt'] }}"
                        >
                    </figure>
                @endif
                @if ($project['beforeAfter']['after'])
                    <figure class="flex flex-col gap-3 md:gap-6">
                        <figcaption class="text-center text-[20px] font-medium text-neutral-900 md:text-[28px] md:font-semibold">
                            {{ __('work.after') }}
                        </figcaption>
                        <img loading="lazy" decoding="async"
                            class="h-[181px] w-full rounded-sm object-cover shadow-[0_4px_10px_rgba(0,0,0,0.05)] md:h-[306px]"
                            src="{{ $project['beforeAfter']['after']['src'] }}"
                            alt="{{ $project['beforeAfter']['after']['alt'] }}"
                        >
                    </figure>
                @endif
            </section>
        @endif
        @if ($project['next'])
            <section class="mt-[58px] flex flex-col gap-2 md:mt-0 md:gap-8" data-reveal>
                <p class="text-body-lg font-medium text-neutral-800 md:text-[24px]">{{ __('work.next_case_study') }}</p>
                <a
                    class="group inline-flex w-fit items-center gap-2 rounded-sm text-[26px] font-medium text-neutral-1000 transition-colors hover:text-gold md:gap-4 md:text-[40px]"
                    href="{{ $project['next']['url'] }}"
                >
                    {{ $project['next']['title'] }}
                    @includeIsolated('public.icon', ['icon' => 'arrow-right', 'class' => 'size-8 transition-transform group-hover:translate-x-1 rtl:-scale-x-100 rtl:group-hover:-translate-x-1 md:size-10', 'ariaHidden' => 'true', 'strokeWidth' => 1.5])
                </a>
            </section>
        @endif
    </div>
    @if ($finalCta)
        @include('public.components.cta-banner', ['spacingClass' => 'pb-[176px] pt-[176px]', 'section' => $finalCta])
    @endif
</div>
