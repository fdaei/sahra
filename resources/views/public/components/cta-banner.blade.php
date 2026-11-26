@php
    $direction = config('locales.supported.'.app()->getLocale().'.direction');
    $horizon = '/images/sahra/dark-gold-horizon-bg'.($direction === 'rtl' ? '-rtl' : '');
    $spacingClass ??= 'pb-[176px] pt-[176px]';
@endphp

<section dir="{{ $direction }}" class="{{ $spacingClass }} {{ $class ?? '' }}">
    <div class="container-sahra">
        <div class="relative flex min-h-[359px] flex-col justify-center gap-2 overflow-hidden rounded-lg bg-ink p-6 md:min-h-[483px] md:p-14">
            <img
                alt=""
                width="1672"
                height="941"
                class="pointer-events-none absolute inset-x-0 -top-[10%] h-[120%] w-full object-cover object-center"
                aria-hidden="true"
                decoding="async" loading="lazy" fetchpriority="low"
                src="{{ $horizon }}-960.webp"
                srcset="{{ $horizon }}-480.webp 480w, {{ $horizon }}-960.webp 960w, {{ $horizon }}-1672.webp 1672w"
                sizes="(min-width: 1440px) 1248px, calc(100vw - 40px)"
               
            >
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/75 via-black/40 to-black/10 rtl:bg-gradient-to-l"
                aria-hidden="true"
            ></div>
            <p
                class="relative z-10 font-display text-[16px] leading-6 text-gold md:text-[24px] md:leading-[26px]"
                style="color: {{ ($section['colors']['eyebrow'] ?: null) }};"
            >
                {{ $section['eyebrow'] }}
            </p>
            <div class="relative z-10 flex flex-col gap-6 md:gap-10">
                <div class="flex flex-col gap-10 md:gap-12">
                    <div class="flex flex-col gap-4 md:gap-6">
                        <h2
                            class="text-[24px] font-semibold leading-normal text-paper md:text-display-md lg:max-w-[505px]"
                            style="color: {{ ($section['colors']['title'] ?: null) }};"
                        >
                            {{ $section['title'] }}
                        </h2>
                        <p
                            class="text-body-md text-neutral-100 md:text-title-sm md:font-medium lg:max-w-[715px]"
                            style="color: {{ ($section['colors']['description'] ?: null) }};"
                        >
                            {{ $section['description'] }}
                        </p>
                    </div>
                    @if ($section['primaryCta'])
                        <a
                            class="final-cta-button group inline-flex w-fit items-center gap-1 self-start rounded-sm bg-paper px-3 py-3 text-body-md text-ink transition-colors hover:bg-gold hover:text-white md:px-6 md:text-title-sm"
                            href="{{ $section['primaryCta']['url'] }}"
                        >
                            {{ $section['primaryCta']['label'] }}
                            @if (($section['primaryCta']['icon'] || $section['primaryCta']['hoverIcon']))
                                @includeIsolated('public.components.button-icon', ['class' => 'size-5 md:size-6', 'name' => $section['primaryCta']['icon'], 'hoverName' => $section['primaryCta']['hoverIcon']])
                            @else
                                @includeIsolated('public.icon', ['icon' => 'arrow-right', 'class' => 'hidden size-5 shrink-0 rtl:-scale-x-100 md:block md:size-6', 'ariaHidden' => 'true'])
                            @endif
                        </a>
                    @endif
                </div>
                @if ($section['subtitle'])
                    <p
                        class="text-[12px] font-medium leading-normal text-neutral-300 md:text-title-sm md:text-neutral-100"
                        style="color: {{ ($section['colors']['subtitle'] ?: null) }};"
                    >
                        {{ $section['subtitle'] }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
