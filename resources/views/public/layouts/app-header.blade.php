@php
    $navItems = $minimal ? [] : \App\Support\NavigationBuilder::header($locale);
    $items = array_values(array_filter($navItems, fn ($item) => ! $item['isCta']));
    $cta = collect($navItems)->firstWhere('isCta', true);
    $siteName = $settings['siteName'] ?? config('app.name');
    $currentPath = rawurldecode(request()->getPathInfo());
    $homePath = '/'.$locale;
    $isActive = static function (?string $url) use ($currentPath, $homePath): bool {
        if (blank($url)) {
            return false;
        }
        $path = rawurldecode(parse_url($url, PHP_URL_PATH) ?: '');
        return $path !== '' && ($currentPath === $path || ($path !== $homePath && str_starts_with($currentPath, $path.'/')));
    };
    $isTreeActive = static function (array $item) use ($isActive, &$isTreeActive): bool {
        return $isActive($item['url']) || collect($item['children'])->contains($isTreeActive);
    };
@endphp

<header class="pointer-events-none fixed inset-inline-0 top-0 z-header backdrop-blur-header bg-white/5">
    <div
        class="mx-auto flex w-full max-w-frame items-center px-5 py-6 lg:px-24 {{ \Illuminate\Support\Arr::toCssClasses(($minimal ? 'justify-between' : 'lg:gap-[262px]')) }}"
    >
        <a
            class="pointer-events-auto w-[120px] shrink-0 rounded-sm focus-visible:ring-2 focus-visible:ring-gold lg:w-[140px]"
            href="{{ ('/' . $locale) }}"
            aria-label="{{ $siteName }}"
        >
            @includeIsolated('public.components.brand-logo', ['variant' => 'full', 'class' => 'h-[48px] w-[120px] lg:h-[56px] lg:w-[140px]', 'height' => 56, 'label' => $siteName])
        </a>
        <div
            class="pointer-events-auto hidden items-center lg:flex {{ \Illuminate\Support\Arr::toCssClasses(($minimal ? 'ms-auto' : 'w-[846px] justify-between')) }}"
        >
            @if (!$minimal)
                <nav aria-label="{{ __('common.primary_navigation') }}">
                    <ul class="flex items-center gap-6">
                        @foreach ($items as $item)
                            @if (count($item['children']))
                                @include('public.layouts.nav-dropdown', ['item' => $item, 'active' => $isTreeActive($item), 'isActive' => $isActive])
                            @else
                                <li>
                                    <a
                                        class="flex items-center justify-center px-1 py-1 text-title-sm transition-colors {{ \Illuminate\Support\Arr::toCssClasses(($isActive($item['url']) ? 'font-medium text-ink' : 'font-medium text-neutral-800 hover:text-ink')) }}"
                                        href="{{ $item['url'] }}"
                                        target="{{ $item['target'] }}"
                                        @if (($isActive($item['url']) ? 'page' : null)) aria-current="{{ ($isActive($item['url']) ? 'page' : null) }}" @endif
                                        rel="noopener"
                                    >
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </nav>
            @endif
            <div class="flex items-center justify-center gap-4">
                @if (!$minimal)
                    @include('public.components.language-switcher')
                @endif
                @if ($cta)
                    <a
                        class="group flex items-center gap-1 rounded-sm bg-ink px-6 py-3 text-title-sm text-paper transition-colors hover:bg-gold hover:text-white"
                        href="{{ $cta['url'] }}"
                    >
                        {{ $cta['label'] }}
                        @includeIsolated('public.components.button-icon', ['name' => $cta['icon'], 'hoverName' => $cta['hoverIcon']])
                    </a>
                @endif
            </div>
        </div>
        @if (!$minimal)
            <div class="pointer-events-auto ms-auto flex items-center gap-1 lg:hidden">
                @include('public.components.language-switcher')
                <button
                    type="button"
                    class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-ink"
                    aria-haspopup="dialog"
                    aria-label="{{ __('common.open_menu') }}"
                    aria-expanded="false" aria-controls="mobile-menu"
                    data-action="openMenu"
                >
                    @includeIsolated('public.icon', ['icon' => 'menu', 'class' => 'size-6', 'ariaHidden' => 'true'])
                </button>
            </div>
        @endif
    </div>
</header>
@unless ($minimal)
    @include('public.layouts.mobile-menu')
@endunless
