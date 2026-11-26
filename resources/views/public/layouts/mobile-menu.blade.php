<dialog id="mobile-menu" class="mobile-menu fixed end-0 start-auto top-0 m-0 max-h-none max-w-none bg-transparent p-0" aria-label="{{ __('common.primary_navigation') }}">
    <div
        class="flex h-dvh w-[min(88vw,22rem)] min-h-0 flex-col bg-paper pb-safe pt-safe shadow-card lg:hidden"
        aria-label="{{ __('common.primary_navigation') }}"
    >
        <div class="flex items-center justify-between px-5 py-6">
            @includeIsolated('public.components.brand-logo', ['variant' => 'full', 'label' => '', 'height' => 40])
            <button
                type="button"
                class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-neutral-900"
                aria-label="{{ __('common.close_menu') }}"
               
                data-action="closeMenu"
            >
                @includeIsolated('public.icon', ['icon' => 'x', 'class' => 'size-6', 'ariaHidden' => 'true'])
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto px-5" aria-label="{{ __('common.primary_navigation') }}">
            <ul class="flex flex-col">
                @foreach ($items as $item)
                    <li class="border-b border-neutral-100">
                        <div class="flex items-center justify-between gap-2">
                            @if ($item['url'])
                                <a
                                    class="block flex-1 py-5 text-title-md transition-colors hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($isTreeActive($item) ? 'font-medium text-ink' : 'text-neutral-800')) }}"
                                    href="{{ $item['url'] }}"
                                    target="{{ $item['target'] }}"
                                    @if (($isActive($item['url']) ? 'page' : null)) aria-current="{{ ($isActive($item['url']) ? 'page' : null) }}" @endif
                                    data-action="closeMenu"
                                    rel="noopener"
                                >
                                    {{ $item['label'] }}
                                </a>
                            @else
                                <span class="flex-1 py-5 text-title-md text-neutral-800">{{ $item['label'] }}</span>
                            @endif
                            @if (count($item['children']))
                                <button
                                    type="button"
                                    class="touch-target -me-2 inline-flex size-11 items-center justify-center rounded-sm text-neutral-800"
                                    aria-expanded="{{ ($isTreeActive($item) ? 'true' : 'false') }}"
                                    aria-controls="m-sub-{{ $item['id'] }}" data-disclosure
                                    aria-label="{{ $item['label'] }}"
                                >
                                    @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'size-5 transition-transform duration-200', 'ariaHidden' => 'true'])
                                </button>
                            @endif
                        </div>
                        @if (count($item['children']))
                            <ul class="flex flex-col pb-4 ps-3" id="m-sub-{{ $item['id'] }}" @if (!$isTreeActive($item)) hidden @endif>
                                @foreach ($item['children'] as $child)
                                    <li>
                                        @if ($child['url'])
                                            <a
                                                class="block py-2.5 text-body-lg transition-colors hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($isActive($child['url']) ? 'font-medium text-ink' : 'text-neutral-700')) }}"
                                                href="{{ $child['url'] }}"
                                                target="{{ $child['target'] }}"
                                                @if (($isActive($child['url']) ? 'page' : null)) aria-current="{{ ($isActive($child['url']) ? 'page' : null) }}" @endif
                                                data-action="closeMenu"
                                                rel="noopener"
                                            >
                                                {{ $child['label'] }}
                                            </a>
                                        @else
                                            <span class="block py-2.5 text-body-lg font-medium text-neutral-900">{{ $child['label'] }}</span>
                                        @endif
                                        @if (count($child['children']))
                                            <ul class="flex flex-col border-s border-neutral-100 ps-3">
                                                @foreach ($child['children'] as $grandchild)
                                                    <li>
                                                        <a
                                                            class="block py-2 text-[14px] transition-colors hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($isActive($grandchild['url']) ? 'font-medium text-ink' : 'text-neutral-600')) }}"
                                                            href="{{ $grandchild['url'] }}"
                                                            target="{{ $grandchild['target'] }}"
                                                            @if (($isActive($grandchild['url']) ? 'page' : null)) aria-current="{{ ($isActive($grandchild['url']) ? 'page' : null) }}" @endif
                                                            data-action="closeMenu"
                                                            rel="noopener"
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
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="flex flex-col gap-4 border-t border-neutral-100 px-5 py-6">
            @if ($cta)
                <a
                    class="inline-flex items-center justify-center rounded-sm bg-ink px-6 py-4 text-label-lg text-paper transition-colors hover:bg-gold hover:text-white group"
                    href="{{ $cta['url'] }}"
                    data-action="closeMenu"
                >
                    {{ $cta['label'] }}
                    @includeIsolated('public.components.button-icon', ['name' => $cta['icon'], 'hoverName' => $cta['hoverIcon']])
                </a>
            @endif
        </div>
    </div>
</dialog>
