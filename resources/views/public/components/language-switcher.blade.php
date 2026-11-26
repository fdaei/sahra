@php
    $currentLabel = config("locales.supported.{$locale}.native");
    $availableLocales = [];
    foreach ($alternates as $code => $url) {
        $availableLocales[] = ['code' => $code, ...config("locales.supported.{$code}")];
    }
    $isCurrent = fn (string $code) => $code === $locale;
@endphp

<details class="language-switcher relative">
    <summary
        class="flex cursor-pointer list-none items-center gap-2 rounded-xs p-2 text-label-lg text-neutral-800 transition-colors hover:text-gold focus-visible:ring-2 focus-visible:ring-gold [&::-webkit-details-marker]:hidden"
        aria-label="{{ __('common.change_language') }}"
    >
        <span class="flex items-center gap-1">
            @includeIsolated('public.icon', ['icon' => 'globe', 'class' => 'size-5', 'ariaHidden' => 'true'])
            <span>{{ $currentLabel }}</span>
        </span>
        @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'size-5 transition-transform [details[open]_&]:rotate-180', 'ariaHidden' => 'true'])
    </summary>
    <ul
        class="absolute inset-inline-end-0 top-full z-menu mt-2 min-w-44 overflow-hidden rounded-sm border border-neutral-100 bg-paper py-1 shadow-card"
    >
        @foreach ($availableLocales as $option)
            <li>
                <a
                    class="flex w-full items-center justify-between gap-3 px-4 py-3 text-start text-body-md transition-colors hover:bg-gold hover:text-white focus-visible:bg-gold focus-visible:text-white focus-visible:outline-none {{ \Illuminate\Support\Arr::toCssClasses(($isCurrent($option['code']) ? 'text-gold' : 'text-neutral-800')) }}"
                    href="{{ $alternates[$option['code']] }}"
                    lang="{{ $option['code'] }}"
                    dir="{{ $option['direction'] }}"
                    @if (($isCurrent($option['code']) ? 'true' : null)) aria-current="{{ ($isCurrent($option['code']) ? 'true' : null) }}" @endif
                >
                    <span>{{ $option['native'] }}</span>
                    @if ($isCurrent($option['code']))
                        @includeIsolated('public.icon', ['icon' => 'check', 'class' => 'size-4 shrink-0', 'ariaHidden' => 'true'])
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</details>
