<?php

declare(strict_types=1);

$configuredOrigin = env('SEO_CANONICAL_ORIGIN');

return [
    // Leave unset locally; production defaults to the non-www site host.
    'canonical_origin' => filled($configuredOrigin)
        ? $configuredOrigin
        : (env('APP_ENV') === 'production' ? 'https://sahramarketing.com' : null),
    'require_ssr' => (bool) env('SEO_REQUIRE_SSR', env('APP_ENV') === 'production'),
];
