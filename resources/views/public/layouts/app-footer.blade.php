@php
    $columns = \App\Support\NavigationBuilder::footer($locale);
    $year = now()->year;
    $privacyUrl = route('legal.privacy', absolute: false);
    $termsUrl = route('legal.terms', absolute: false);
    $columnHeading = fn (int $index, string $label) => $label ?: match ($index) {
        0 => __('footer.quick_links'),
        1 => __('footer.social_links'),
        default => '',
    };
@endphp

<footer
    class="relative overflow-hidden rounded-t-lg border-t border-neutral-100 bg-paper shadow-[0_-5px_10px_rgba(0,0,0,0.05)] {{ $fontClass }}"
    lang="{{ $htmlLang }}"
    dir="{{ $direction }}"
>
    <div class="container-sahra relative py-6 md:py-12">
        <div class="relative z-10 flex flex-col gap-2 md:gap-10">
            <div class="grid gap-10 md:grid-cols-2 lg:flex lg:items-start lg:justify-between lg:gap-0">
                <div class="flex max-w-[402px] flex-col items-start gap-4 md:gap-8">
                    @includeIsolated('public.components.brand-logo', ['variant' => 'footer', 'class' => 'h-[28px] w-[87px]', 'height' => 28, 'label' => $settings['siteName']])
                    <p class="text-[12px] font-normal leading-normal text-neutral-600 md:text-[16px]">{{ $settings['description'] }}</p>
                </div>
                <div class="grid grid-cols-2 gap-x-10 gap-y-10 lg:flex lg:shrink-0 lg:items-start lg:gap-[88px]">
                    @foreach ($columns as $columnIndex => $column)
                        <nav aria-label="{{ $columnHeading($columnIndex, $column['label']) }}">
                            <h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">
                                @if ($column['url'])
                                    <a class="transition-colors hover:text-gold" href="{{ $column['url'] }}">
                                        {{ $columnHeading($columnIndex, $column['label']) }}
                                    </a>
                                @else
                                    {{ $columnHeading($columnIndex, $column['label']) }}
                                @endif
                            </h2>
                            <ul class="mt-3 flex flex-col items-start gap-2 md:mt-4 md:gap-3">
                                @foreach ($column['children'] as $child)
                                    <li class="text-[14px] leading-normal">
                                        <a
                                            class="text-[14px] font-normal leading-normal text-neutral-600 transition-colors hover:text-gold md:font-medium"
                                            href="{{ $child['url'] }}"
                                            target="{{ $child['target'] }}"
                                            rel="{{ (($child['target'] === '_blank') ? 'noopener noreferrer' : null) }}"
                                        >
                                            {{ $child['label'] }}
                                        </a>
                                        @if (count($child['children']))
                                            <ul class="mt-2 flex flex-col gap-1.5 border-s border-neutral-200 ps-3 md:gap-2">
                                                @foreach ($child['children'] as $grandchild)
                                                    <li>
                                                        <a
                                                            class="text-[13px] font-normal leading-normal text-neutral-500 transition-colors hover:text-gold"
                                                            href="{{ $grandchild['url'] }}"
                                                            target="{{ $grandchild['target'] }}"
                                                            rel="{{ (($grandchild['target'] === '_blank') ? 'noopener noreferrer' : null) }}"
                                                        >
                                                            {{ $grandchild['label'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endforeach
                    <div class="col-span-2 lg:col-span-1">
                        <h2 class="text-[14px] font-medium leading-normal text-neutral-900 md:text-[16px]">{{ __('footer.info') }}</h2>
                        <ul class="mt-3 flex flex-col gap-2 text-[14px] font-normal leading-normal text-neutral-600 md:mt-4 md:gap-3 md:font-medium">
                            @if ($settings['contact']['location'])
                                <li class="flex items-center gap-2">
                                    @includeIsolated('public.icon', ['icon' => 'map-pin', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true'])
                                    <span>{{ $settings['contact']['location'] }}</span>
                                </li>
                            @endif
                            @if ($settings['contact']['phone'])
                                <li class="flex items-center gap-2">
                                    @includeIsolated('public.icon', ['icon' => 'phone', 'class' => 'size-4 shrink-0 text-neutral-600', 'ariaHidden' => 'true'])
                                    <a class="latin-nums transition-colors hover:text-gold" href="{{ ('tel:' . preg_replace('/\\s/', '', $settings['contact']['phone'])) }}">
                                        {{ $settings['contact']['phone'] }}
                                    </a>
                                </li>
                            @endif
                            @if ($settings['contact']['email'])
                                <li class="flex items-center gap-2">
                                    @includeIsolated('public.icon', ['icon' => 'mail', 'class' => 'size-6 shrink-0 text-neutral-600', 'ariaHidden' => 'true'])
                                    <a class="break-all transition-colors hover:text-gold" href="{{ ('mailto:' . $settings['contact']['email']) }}">
                                        {{ $settings['contact']['email'] }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div
                class="relative z-10 flex flex-col items-start justify-between gap-4 border-t border-neutral-300 py-6 text-[12px] font-medium leading-normal text-neutral-600 sm:flex-row sm:items-center sm:gap-3 sm:text-[14px]"
            >
                <p>{{ __('footer.copyright', ['year' => $year, 'name' => $settings['copyrightName']]) }}</p>
                <div class="flex items-center gap-4">
                    <a class="underline transition-colors hover:text-gold" href="{{ $privacyUrl }}">{{ __('footer.privacy_policy') }}</a>
                    <a class="underline transition-colors hover:text-gold" href="{{ $termsUrl }}">{{ __('footer.terms') }}</a>
                </div>
            </div>
        </div>
        <img
            src="/icons/sahra/footer-wordmark.svg"
            alt=""
            width="1248"
            height="305"
            class="pointer-events-none absolute inset-inline-0 bottom-0 w-full translate-y-[45.15%] select-none"
            aria-hidden="true"
            decoding="async"
        >
    </div>
</footer>
