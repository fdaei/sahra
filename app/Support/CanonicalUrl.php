<?php

declare(strict_types=1);

namespace App\Support;

final class CanonicalUrl
{
    public static function origin(): string
    {
        return rtrim((string) (config('seo.canonical_origin') ?: config('app.url')), '/');
    }

    public static function for(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '';

        return self::origin().'/'.ltrim(rtrim($path, '/'), '/');
    }

    public static function route(string $name, array $parameters = []): string
    {
        return self::for(route($name, $parameters, absolute: false));
    }
}
