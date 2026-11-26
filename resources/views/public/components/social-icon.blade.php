@php
    $number = match ($icon) {
        'instagram' => 0,
        'linkedin' => 1,
        'whatsapp', 'message-circle' => 2,
        'x', 'twitter' => 3,
        'youtube' => 4,
        default => null,
    };
    $name = $number === null
        ? (\App\Support\IconUrl::isImage($icon) || $icon === 'facebook' ? $icon : 'link2')
        : '/icons/sahra/contact/social'.($number ? '-'.$number : '').'.svg';
@endphp
@includeIsolated('public.components.button-icon', [
    'name' => $name,
    'hoverName' => match ($hoverIcon ?? null) {
        'whatsapp' => 'message-circle',
        'x' => 'twitter',
        default => $hoverIcon ?? null,
    },
    'class' => $class ?? '',
])
