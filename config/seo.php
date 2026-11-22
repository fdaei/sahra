<?php

declare(strict_types=1);

$configuredOrigin = env('SEO_CANONICAL_ORIGIN');

return [
    // Leave unset locally; production defaults to the non-www site host.
    // Maximum published records per sitemap shard (clamped to 1–1000).
    'sitemap_chunk_size' => (int) env('SEO_SITEMAP_CHUNK_SIZE', 1000),

    'canonical_origin' => filled($configuredOrigin)
        ? $configuredOrigin
        : (env('APP_ENV') === 'production' ? 'https://sahramarketing.com' : null),
];
