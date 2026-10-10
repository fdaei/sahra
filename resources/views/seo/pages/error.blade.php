{{-- Fallback for Pages/Error.vue. --}}
@php
    $status = (int) ($props['status'] ?? 500);
    $key = in_array($status, [403, 404, 429, 500, 503], true) ? (string) $status : '500';
@endphp
<section>
    <p>{{ $status }}</p>
    <h1>{{ __("errors.{$key}.title") }}</h1>
    <p>{{ __("errors.{$key}.message") }}</p>
    <a href="/{{ $props['locale']['current'] ?? app()->getLocale() }}">{{ $props['settings']['siteName'] ?? config('app.name') }}</a>
</section>
