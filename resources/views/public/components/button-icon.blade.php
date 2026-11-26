@if (filled($name ?? null) && filled($hoverName ?? null) && $name !== $hoverName)
    <span class="relative inline-flex size-[1em] shrink-0 {{ $class ?? '' }}" aria-hidden="true">
        @includeIsolated('public.icon', [
            'icon' => $name,
            'class' => 'size-full object-contain transition-opacity duration-200 group-hover:opacity-0 group-focus-within:opacity-0',
        ])
        @includeIsolated('public.icon', [
            'icon' => $hoverName,
            'class' => 'absolute inset-0 size-full object-contain opacity-0 transition-opacity duration-200 group-hover:opacity-100 group-focus-within:opacity-100',
        ])
    </span>
@else
    @includeIsolated('public.icon', ['icon' => ($name ?? '') ?: ($hoverName ?? null), 'class' => $class ?? 'size-[1em] shrink-0'])
@endif
