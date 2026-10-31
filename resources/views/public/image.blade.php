@if (!empty($image))
    <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}"
         width="{{ $image['width'] }}" height="{{ $image['height'] }}"
         @if (!empty($image['srcset'])) srcset="{{ $image['srcset'] }}" sizes="{{ $image['sizes'] }}" @endif
         loading="{{ $eager ?? false ? 'eager' : 'lazy' }}" decoding="async"
         class="my-6 h-auto max-w-full rounded-lg">
@endif
