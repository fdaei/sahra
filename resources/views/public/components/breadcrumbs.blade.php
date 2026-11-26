<nav class="pointer-events-none absolute inset-inline-0 top-[100px] z-20 md:top-[120px]" aria-label="{{ __('common.breadcrumbs') }}">
    <ol
        class="container-sahra pointer-events-auto flex items-center gap-1.5 overflow-x-auto whitespace-nowrap text-[12px] leading-normal text-neutral-500 [scrollbar-width:none] md:text-[14px]"
    >
        @foreach ($items as $index => $item)
            <li
                class="flex min-w-0 items-center gap-1.5 {{ \Illuminate\Support\Arr::toCssClasses((($index === (count($items) - 1)) ? 'shrink' : 'shrink-0')) }}"
            >
                @if (($index > 0))
                    @includeIsolated('public.icon', ['icon' => 'chevron-right', 'class' => 'size-3.5 shrink-0 text-neutral-400 rtl:-scale-x-100', 'ariaHidden' => 'true'])
                @endif
                @if (($index === (count($items) - 1)))
                    <span aria-current="page" class="max-w-[60vw] truncate font-medium text-neutral-900 md:max-w-[36rem]">{{ $item['name'] }}</span>
                @else
                    <a class="rounded-xs transition-colors hover:text-gold focus-visible:ring-2 focus-visible:ring-gold" href="{{ $item['href'] }}">
                        {{ $item['name'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
