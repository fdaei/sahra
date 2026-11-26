<section class="relative isolate overflow-hidden bg-black py-12 text-paper md:py-24 {{ $class ?? '' }}" data-figma-node="1419:9323">
    <div class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 aspect-[1440/406] w-full overflow-hidden opacity-40">
        <img src="/images/sahra/packages-bg-480.webp"
             srcset="/images/sahra/packages-bg-480.webp 480w, /images/sahra/packages-bg-1396.webp 1396w"
             sizes="100vw" loading="lazy" decoding="async" fetchpriority="low" alt="" class="absolute inset-x-0 top-0 aspect-[1440/558] w-full object-cover">
    </div>
    <div class="mx-auto w-full max-w-[1248px] px-5 md:px-10 xl:px-0">
        <div class="flex flex-col gap-8 md:gap-12">
            <div class="eyebrow">{{ $section['eyebrow'] }}</div>
            <div class="grid gap-6 lg:grid-cols-[506px_minmax(0,612px)] lg:justify-between lg:gap-[130px]">
                <h2 class="max-w-[506px] text-[26px] font-semibold leading-normal text-paper md:text-display-md">{{ $section['title'] }}</h2>
                <p class="max-w-[612px] text-[16px] font-medium leading-normal text-neutral-100 md:text-title-sm">{{ $section['subtitle'] }}</p>
            </div>
        </div>
        <div
            class="mt-12 grid items-center gap-6 md:mt-18 md:grid-cols-2 {{ \Illuminate\Support\Arr::toCssClasses(['xl:grid-cols-3' => (count($section['items']) >= 3)]) }}"
        >
            @foreach ($section['items'] as $item)
                <article class="package-card {{ \Illuminate\Support\Arr::toCssClasses(['package-card--featured' => $item['badge']]) }}">
                    <div class="package-card__body">
                        <div class="flex items-center gap-2">
                            <h3 class="text-[24px] font-medium leading-none text-neutral-50 md:text-[28px]">{{ $item['title'] }}</h3>
                            @if ($item['badge'])
                                <span class="rounded-round bg-gold/15 px-2 py-1 text-[10px] leading-none text-paper md:text-label-md">
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-label-md leading-none text-neutral-200 md:text-label-lg">{{ $item['label'] }}</p>
                            <p class="mt-2 flex flex-wrap items-baseline gap-1 text-gold">
                                <span
                                    class="latin-nums leading-normal {{ \Illuminate\Support\Arr::toCssClasses(($item['badge'] ? 'text-[32px] md:text-[40px]' : 'text-[28px] md:text-[32px]')) }}"
                                >
                                    {{ $item['value'] }}
                                </span>
                                <span class="text-body-lg leading-normal text-gold-300 md:text-title-sm">{{ $item['suffix'] }}</span>
                            </p>
                            <p class="mt-4 text-label-md leading-normal text-neutral-300 md:text-body-md">{{ $item['description'] }}</p>
                        </div>
                        <div class="h-px bg-neutral-800" aria-hidden="true"></div>
                        <ul class="flex flex-1 flex-col gap-4 md:gap-6">
                            @foreach ($item['features'] as $feature)
                                <li class="flex items-center gap-[10px] text-body-lg leading-none text-neutral-100">
                                    @include('public.components.icons.package-check-icon')
                                    <span class="min-w-0">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="h-px bg-neutral-800" aria-hidden="true"></div>
                    </div>
                    <p class="text-center text-body-lg leading-none text-neutral-100">{{ $item['footer'] }}</p>
                </article>
            @endforeach
        </div>
        <div
            class="mt-12 flex items-end justify-between gap-4 rounded-sm border border-neutral-800 bg-white/[0.07] px-4 py-6 md:mt-18 md:items-center md:gap-8 md:px-16 md:py-16"
        >
            <div class="flex-1">
                <h3 class="text-title-sm leading-none text-paper md:text-title-lg">{{ $section['content'] }}</h3>
                <p class="mt-3 text-label-md leading-none text-neutral-200 md:mt-2 md:text-body-lg md:text-neutral-100">{{ $section['description'] }}</p>
            </div>
            @if ($section['primaryCta'])
                <a
                    class="group inline-flex min-h-11 shrink-0 items-center justify-center gap-1 rounded-sm border border-paper px-3 py-3 text-body-md text-paper transition-colors hover:border-gold hover:bg-gold hover:text-white md:min-h-14 md:px-8 md:py-4 md:text-title-md"
                    href="{{ $section['primaryCta']['url'] }}"
                >
                    {{ $section['primaryCta']['label'] }}
                    @includeIsolated('public.components.button-icon', ['name' => $section['primaryCta']['icon'], 'hoverName' => $section['primaryCta']['hoverIcon']])
                </a>
            @endif
        </div>
    </div>
</section>
