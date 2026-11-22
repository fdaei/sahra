<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;

final class SeoCanonical
{
    private const PAGE_ROUTES = [
        'home' => 'home', 'work' => 'work.index', 'services' => 'services', 'about' => 'about',
        'insights' => 'insights.index', 'contact' => 'contact', 'privacy-policy' => 'legal.privacy', 'terms' => 'legal.terms',
    ];

    public static function override(Page|Post|Project|null $model, ?string $locale = null): ?string
    {
        if ($model === null) {
            return null;
        }
        // Canonical URLs are language-specific and must never fall back to another language.
        $url = trim((string) $model->getTranslation('seo_canonical_url', $locale, false));
        return self::valid($url) ? $url : null;
    }

    public static function valid(string $url): bool
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $parts = parse_url($url);
        return is_array($parts) && in_array(strtolower($parts['scheme'] ?? ''), ['http', 'https'], true)
            && ! empty($parts['host']) && ! isset($parts['user']) && ! isset($parts['pass']) && ! isset($parts['fragment']);
    }

    public static function defaultUrl(Page|Post|Project $model, string $locale): ?string
    {
        if ($model instanceof Page) {
            $route = self::PAGE_ROUTES[$model->key] ?? null;
            return $route === null ? null : CanonicalUrl::route($route, ['locale' => $locale]);
        }
        return $model->hasSlugForLocale($locale) ? CanonicalUrl::for($model->url($locale)) : null;
    }

    public static function isSelfCanonical(Page|Post|Project $model, string $locale): bool
    {
        $override = self::override($model, $locale);
        if ($override === null) {
            return true;
        }
        $default = self::defaultUrl($model, $locale);
        return $default !== null && self::normalize($override) === self::normalize($default);
    }

    private static function normalize(string $url): string
    {
        $parts = parse_url($url);
        $scheme = strtolower($parts['scheme'] ?? '');
        $port = $parts['port'] ?? null;
        $authority = strtolower($parts['host'] ?? '');
        if ($port !== null && !(($scheme === 'http' && $port === 80) || ($scheme === 'https' && $port === 443))) {
            $authority .= ':'.$port;
        }
        $path = rtrim($parts['path'] ?? '', '/');
        return $scheme.'://'.$authority.($path === '' ? '/' : $path).(isset($parts['query']) ? '?'.$parts['query'] : '');
    }
}
