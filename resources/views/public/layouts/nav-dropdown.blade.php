@php
    $isMega = collect($item['children'])->contains(fn ($child) => !empty($child['children']));
    $panelId = 'nav-panel-'.$item['id'];
@endphp

<li class="relative" data-nav-dropdown>
    <div class="flex items-center">
        @if ($item['url'])
            <a
                class="flex items-center justify-center py-1 ps-1 text-title-sm font-medium transition-colors {{ \Illuminate\Support\Arr::toCssClasses(($active ? 'text-ink' : 'text-neutral-800 hover:text-ink')) }}"
                href="{{ $item['url'] }}"
                target="{{ $item['target'] }}"
                @if (($isActive($item['url']) ? 'page' : null)) aria-current="{{ ($isActive($item['url']) ? 'page' : null) }}" @endif
                rel="noopener"
            >
                {{ $item['label'] }}
            </a>
        @endif
        <button
            type="button"
            class="flex items-center gap-1 rounded-xs py-1 pe-1 text-title-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-gold {{ \Illuminate\Support\Arr::toCssClasses([($item['url'] ? 'ps-0.5' : 'ps-1'), ($active ? 'text-ink' : 'text-neutral-800 hover:text-ink')]) }}"
            aria-expanded="false"
            aria-controls="{{ $panelId }}"
            @if (($item['url'] ? $item['label'] : null)) aria-label="{{ ($item['url'] ? $item['label'] : null) }}" @endif
           
            data-action="toggle"
        >
            @if (!$item['url'])
                {{ $item['label'] }}
            @endif
            @includeIsolated('public.icon', ['icon' => 'chevron-down', 'class' => 'size-4 transition-transform duration-200', 'ariaHidden' => 'true'])
        </button>
    </div>
        <div class="absolute start-0 top-full z-header pt-3" id="{{ $panelId }}" hidden>
            <div
                class="rounded-md border border-neutral-100 bg-paper shadow-card {{ \Illuminate\Support\Arr::toCssClasses(($isMega ? 'grid w-max max-w-[min(90vw,46rem)] grid-cols-[repeat(auto-fill,minmax(11rem,1fr))] gap-x-2 gap-y-3 p-4' : 'min-w-[14rem] p-2')) }}"
            >
                @if ($isMega)
                    @foreach ($item['children'] as $child)
                        <div class="flex flex-col gap-1">
                            @if ($child['url'])
                                <a
                                    class="rounded-sm px-3 py-2 text-[15px] font-medium text-ink transition-colors hover:bg-neutral-100 hover:text-gold"
                                    href="{{ $child['url'] }}"
                                    target="{{ $child['target'] }}"
                                    @if (($isActive($child['url']) ? 'page' : null)) aria-current="{{ ($isActive($child['url']) ? 'page' : null) }}" @endif
                                    rel="noopener"
                                >
                                    {{ $child['label'] }}
                                </a>
                            @else
                                <span class="px-3 py-2 text-[15px] font-medium text-ink">{{ $child['label'] }}</span>
                            @endif
                            @if (count($child['children']))
                                <ul class="ms-3 flex flex-col border-s border-neutral-100">
                                    @foreach ($child['children'] as $grandchild)
                                        <li>
                                            <a
                                                class="block rounded-sm px-3 py-1.5 text-[14px] text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($isActive($grandchild['url']) ? 'font-medium text-ink' : '')) }}"
                                                href="{{ $grandchild['url'] }}"
                                                target="{{ $grandchild['target'] }}"
                                                @if (($isActive($grandchild['url']) ? 'page' : null)) aria-current="{{ ($isActive($grandchild['url']) ? 'page' : null) }}" @endif
                                                rel="noopener"
                                            >
                                                {{ $grandchild['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @else
                    <ul class="flex flex-col">
                        @foreach ($item['children'] as $child)
                            <li>
                                <a
                                    class="block rounded-sm px-3 py-2.5 text-[15px] text-neutral-800 transition-colors hover:bg-neutral-100 hover:text-gold {{ \Illuminate\Support\Arr::toCssClasses(($isActive($child['url']) ? 'font-medium text-ink' : '')) }}"
                                    href="{{ $child['url'] }}"
                                    target="{{ $child['target'] }}"
                                    @if (($isActive($child['url']) ? 'page' : null)) aria-current="{{ ($isActive($child['url']) ? 'page' : null) }}" @endif
                                    rel="noopener"
                                >
                                    {{ $child['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
</li>
