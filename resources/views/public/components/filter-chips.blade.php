<nav class="mt-16 mb-12 flex items-center gap-4 overflow-x-auto md:mb-0 md:mt-0 md:items-start lg:flex-col lg:overflow-visible"
     aria-label="{{ $paramName === 'category' ? __('blog.categories') : __('work.services') }}">
    @foreach ([['slug' => null, 'name' => __('common.all')], ...$items] as $item)
        @php
            $selected = $active === $item['slug'];
            $depth = $item['depth'] ?? 0;
            $query = http_build_query(array_filter([...$extraParams, $paramName => $item['slug']], fn ($value) => filled($value)));
        @endphp
        <a href="{{ $basePath }}{{ $query === '' ? '' : '?'.$query }}"
           @class([
               'w-fit shrink-0 whitespace-nowrap rounded-xs transition-colors',
               'text-[16px] font-medium text-neutral-1000 md:text-[18px] md:font-normal' => $selected,
               'text-[14px] font-medium text-neutral-500 hover:text-neutral-800 md:text-[16px] md:font-normal' => !$selected,
               'lg:border-s lg:border-neutral-200' => $depth > 0,
           ])
           @if ($selected) aria-current="true" @endif
           @if ($depth > 0) style="padding-inline-start: {{ $depth * 0.875 }}rem" @endif>
            {{ $item['name'] }}
        </a>
    @endforeach
</nav>
