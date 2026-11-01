<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Keeps editor-managed internal URLs in the active locale.
 *
 * Content editors may enter either /contact or a previously copied /en/contact
 * URL. Neither should send a visitor who is browsing in Persian or Arabic back
 * to English. External URLs, anchors, and asset URLs are intentionally left
 * untouched.
 */
final class LocalisedUrl
{
    /** @var array<int, string> */
    private const PUBLIC_PATHS = [
        'about', 'work', 'services', 'insights', 'contact', 'privacy-policy', 'terms',
    ];

    public static function for(string $url, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        if (! str_starts_with($url, '/') || str_starts_with($url, '//')) {
            return $url;
        }

        $parts = parse_url($url);

        if ($parts === false) {
            return $url;
        }

        $path = $parts['path'] ?? '';
        $segments = explode('/', ltrim($path, '/'));
        $first = $segments[0] ?? '';
        $supported = array_keys(config('locales.supported'));

        if (in_array($first, $supported, true)) {
            $segments[0] = $locale;
        } elseif ($first === '' || in_array($first, self::PUBLIC_PATHS, true)) {
            array_unshift($segments, $locale);
        } else {
            return $url;
        }

        $localised = '/'.rtrim(implode('/', $segments), '/');

        if (isset($parts['query'])) {
            $localised .= '?'.$parts['query'];
        }

        if (isset($parts['fragment'])) {
            $localised .= '#'.$parts['fragment'];
        }

        return $localised;
    }
}
