@php
    $mobileProjects = array_slice($projects, 0, 4);
@endphp

<section class="overflow-hidden py-14 md:py-24 lg:py-28 {{ $class ?? '' }}" aria-labelledby="projects-showcase-title" data-project-showcase>
    <div class="container-sahra">
        <div class="flex flex-col gap-20 lg:gap-24">
            <header class="flex flex-col gap-8 lg:gap-12">
                <div class="inline-flex w-fit items-center gap-1 font-display text-[16px] leading-none text-gold md:text-[24px]">
                    <span
                        class="size-2 rotate-45 rounded-round bg-gold shadow-[-2px_-2px_12px_rgba(189,147,59,0.5),2px_2px_12px_rgba(189,147,59,0.5)]"
                        aria-hidden="true"
                    ></span>
                    <span>{{ $section['eyebrow'] }}</span>
                </div>
                <div class="grid items-start gap-6 lg:grid-cols-2 lg:justify-between xl:grid-cols-[506px_612px] xl:gap-0">
                    <h2 id="projects-showcase-title" class="max-w-[506px] text-[26px] font-semibold leading-normal text-neutral-900 lg:text-[40px]">
                        {{ $section['title'] }}
                    </h2>
                    @if ($section['subtitle'])
                        <p class="max-w-[612px] text-[16px] font-medium leading-[1.5] text-neutral-700 lg:text-[18px]">{{ $section['subtitle'] }}</p>
                    @endif
                </div>
            </header>
            @if (count($mobileProjects))
                <div
                    class="project-mobile-carousel flex touch-pan-y select-none flex-col items-center gap-6 lg:hidden"
                    role="region"
                    aria-roledescription="carousel"
                    aria-label="{{ __('common.projects') }}"
                    data-project-mobile
                >
                    @foreach ($mobileProjects as $index => $mobileProject)
                        <article class="flex w-full flex-col gap-6" data-mobile-project="{{ $index }}" @if ($index !== 0) hidden @endif>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between gap-4">
                                    <h3 class="truncate text-[24px] font-medium leading-none text-neutral-900">{{ $mobileProject['title'] }}</h3>
                                    <a
                                        class="inline-flex shrink-0 items-center gap-1 text-[14px] font-medium leading-none text-neutral-900"
                                        href="{{ $mobileProject['url'] }}"
                                    >
                                        {{ __('work.view_case_study') }}
                                        @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-4 rtl:-scale-x-100', 'strokeWidth' => 1.5])
                                    </a>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <span class="flex items-center gap-2 text-[12px] font-medium leading-none text-neutral-500">
                                        @includeIsolated('public.icon', ['icon' => 'building2', 'class' => 'size-4 text-gold', 'strokeWidth' => 1.5])
                                        {{ $mobileProject['industry'] }}
                                    </span>
                                    <p class="text-[14px] font-normal leading-normal text-neutral-800">{{ $mobileProject['excerpt'] }}</p>
                                </div>
                            </div>
                            <a class="aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50" draggable="false" href="{{ $mobileProject['url'] }}">
                                @if ($mobileProject['image'])
                                    <img
                                        class="size-full object-cover" loading="lazy" decoding="async"
                                        draggable="false"
                                        src="{{ $mobileProject['image']['src'] }}"
                                        alt="{{ $mobileProject['image']['alt'] }}"
                                        width="{{ $mobileProject['image']['width'] }}"
                                        height="{{ $mobileProject['image']['height'] }}"
                                    >
                                @endif
                            </a>
                        </article>
                    @endforeach
                    <div class="flex min-h-6 items-center justify-center gap-2" role="group" aria-label="{{ __('common.pagination') }}">
                        @foreach ($mobileProjects as $index => $project)
                            <button
                                type="button"
                                class="h-[10px] rounded-round transition-[width,background-color] duration-300 ease-out {{ \Illuminate\Support\Arr::toCssClasses((($index === 0) ? 'w-5 bg-gold' : 'w-[10px] bg-neutral-300')) }}"
                                aria-label="{{ (($index + 1) . ': ' . $project['title']) }}"
                                @if ((($index === 0) ? 'true' : null)) aria-current="{{ (($index === 0) ? 'true' : null) }}" @endif
                                data-action="selectMobileProject"
                                data-index="{{ $index }}"
                            ></button>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (count($projects))
                <div
                    class="hidden items-center gap-4 lg:grid lg:grid-cols-[minmax(0,612px)_minmax(0,530px)] lg:justify-between lg:gap-10 xl:grid-cols-[612px_530px] xl:gap-0"
                >
                    <div class="order-1 flex min-w-0 flex-col lg:order-1" role="tablist" aria-label="{{ __('common.projects') }}">
                        @foreach ($projects as $index => $project)
                            <article class="project-slide-row {{ \Illuminate\Support\Arr::toCssClasses(['is-active' => ($index === 0)]) }}">
                                <div class="group py-4 lg:py-6" data-project-row="{{ $index }}">
                                    <span class="flex items-center justify-between gap-4">
                                        <button
                                            class="min-w-0 text-start"
                                            type="button"
                                            role="tab"
                                            aria-controls="project-panel-{{ $index }}"
                                            id="{{ ('project-tab-' . $index) }}"
                                            aria-selected="{{ (($index === 0) ? 'true' : 'false') }}"
                                            tabindex="{{ (($index === 0) ? 0 : -1) }}"
                                            data-action="selectProject"
                                            data-index="{{ $index }}"
                                        >
                                            <span
                                                class="project-slide-title min-w-0 text-[26px] font-normal leading-[1.5] text-neutral-500 transition-[color,font-size] duration-500 ease-brand lg:text-[32px]"
                                            >
                                                {{ $project['title'] }}
                                            </span>
                                        </button>

                                            <a data-active-project-link @if ($index !== 0) hidden @endif
                                                class="hidden shrink-0 items-center gap-2 text-body-lg font-medium text-neutral-900 hover:text-gold sm:flex"
                                                href="{{ $project['url'] }}"
                                            >
                                                {{ __('work.view_case_study') }}
                                                @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-5 rtl:-scale-x-100', 'strokeWidth' => 1.5])
                                            </a>
                                    </span>
                                    <button
                                        class="block w-full text-start"
                                        type="button"
                                        tabindex="{{ (($index === 0) ? 0 : -1) }}"
                                        data-action="selectProject"
                                        data-index="{{ $index }}"
                                    >
                                        <span class="project-slide-details grid text-start" aria-hidden="{{ (($index !== 0) ? 'true' : 'false') }}">
                                            <span class="min-h-0 overflow-hidden">
                                                <span class="mt-4 flex items-center gap-2 text-label-lg text-neutral-500">
                                                    @includeIsolated('public.icon', ['icon' => 'building2', 'class' => 'size-5 text-gold', 'strokeWidth' => 1.5])
                                                    {{ $project['industry'] }}
                                                </span>
                                                <span class="mt-4 block max-w-[600px] text-body-lg text-neutral-800">{{ $project['excerpt'] }}</span>
                                            </span>
                                        </span>
                                    </button>

                                        <a data-active-project-link @if ($index !== 0) hidden @endif class="mt-4 inline-flex items-center gap-2 text-body-lg font-medium text-neutral-900 sm:hidden" href="{{ $project['url'] }}">
                                            {{ __('work.view_case_study') }}
                                            @includeIsolated('public.icon', ['icon' => 'arrow-up-right', 'class' => 'size-5 rtl:-scale-x-100', 'strokeWidth' => 1.5])
                                        </a>
                                </div>
                                <div class="project-slide-rule" aria-hidden="true"><span></span></div>
                            </article>
                        @endforeach
                    </div>
                    <div class="order-2 flex min-w-0 flex-col gap-6 lg:order-2">
                        <div class="aspect-[362/453] w-full overflow-hidden rounded-lg bg-neutral-50 lg:aspect-[530/663]">
                            @foreach ($projects as $index => $project)
                                <a
                                    id="project-panel-{{ $index }}" data-desktop-project="{{ $index }}" @if ($index !== 0) hidden @endif
                                    role="tabpanel"
                                    class="block size-full"
                                    href="{{ $project['url'] }}"
                                    aria-labelledby="project-tab-{{ $index }}"
                                >
                                    @if ($project['image'])
                                        <img
                                            class="size-full object-cover" loading="lazy" decoding="async"
                                            src="{{ $project['image']['src'] }}"
                                            alt="{{ $project['image']['alt'] }}"
                                            width="{{ $project['image']['width'] }}"
                                            height="{{ $project['image']['height'] }}"
                                        >
                                    @endif
                                </a>
                            @endforeach
                        </div>
                        @if ((count($projects) > 1))
                            <div class="flex min-h-6 items-center justify-center gap-2" role="group" aria-label="{{ __('common.pagination') }}">
                                @foreach ($projects as $index => $project)
                                    <button
                                        type="button"
                                        class="h-[10px] rounded-round transition-[width,background-color] duration-300 ease-out {{ \Illuminate\Support\Arr::toCssClasses((($index === 0) ? 'w-5 bg-gold hover:bg-gold' : 'w-[10px] bg-neutral-300 hover:bg-neutral-400')) }}"
                                        aria-label="{{ (($index + 1) . ': ' . $project['title']) }}"
                                        @if ((($index === 0) ? 'true' : null)) aria-current="{{ (($index === 0) ? 'true' : null) }}" @endif
                                        data-action="selectDesktopProject"
                                        data-index="{{ $index }}"
                                    ></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
