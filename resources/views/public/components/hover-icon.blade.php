@includeIsolated('public.components.button-icon', [
    'name' => \App\Support\IconUrl::isImage($name ?? null) ? $name : null,
    'hoverName' => \App\Support\IconUrl::isImage($hoverName ?? null) ? $hoverName : null,
    'class' => $class ?? 'size-[1em] shrink-0',
])
