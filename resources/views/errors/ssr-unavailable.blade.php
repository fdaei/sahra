<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('locales.supported.'.app()->getLocale().'.direction', 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,follow">
    <title>{{ __('errors.503.title') }} — Sahra</title>
</head>
<body><main><h1>{{ __('errors.503.title') }}</h1><p>{{ __('errors.503.message') }}</p></main></body>
</html>
