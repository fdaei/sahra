@php
    $ratios = ['full' => 212 / 91, 'mark' => 1, 'footer' => 87 / 28];
    $sources = [
        'full' => '/icons/sahra/logo-full.svg',
        'mark' => '/icons/sahra/logo-mark.svg',
        'footer' => '/icons/sahra/logo-footer.svg',
    ];
@endphp

<img class="{{ $class ?? '' }}"
    class="shrink-0"
    decoding="async"
    src="{{ $sources[$variant] }}"
    alt="{{ $label }}"
    height="{{ $height }}"
    width="{{ (int) round(($height * $ratios[$variant])) }}"
    aria-hidden="{{ (($label === '') ? 'true' : null) }}"
>
