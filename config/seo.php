<?php

declare(strict_types=1);

$configuredOrigin = env('SEO_CANONICAL_ORIGIN');

return [
    // Leave unset locally; production defaults to the non-www site host.
    'canonical_origin' => filled($configuredOrigin)
        ? $configuredOrigin
        : (env('APP_ENV') === 'production' ? 'https://sahramarketing.com' : null),
    // Off by default: without the Node SSR process, the Blade fallback in
    // resources/views/seo/ still puts the head and page copy in the initial
    // HTML. Turn on only where SSR is supervised and a 503 is preferable.
    'require_ssr' => (bool) env('SEO_REQUIRE_SSR', false),
];
