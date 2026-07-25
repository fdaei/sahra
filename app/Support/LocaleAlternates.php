<?php

declare(strict_types=1);

namespace App\Support;

use App\Contracts\HasLocalisedSlugs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Builds the URL of the current page in every supported locale.
 *
 * Powers two things that must never disagree:
 *   1. the language switcher in the header
 *   2. the <link rel="alternate" hreflang="..."> tags
 *
 * Slug-bearing routes are the interesting case: a post has a *different* slug
 * per locale, so /en/insights/content-direction must map to
 * /fa/insights/جهت-محتوا rather than reusing the English slug. Models that
 * implement HasLocalisedSlugs are asked for their translated slug; everything
 * else just swaps the locale segment.
 */
final class LocaleAlternates
{
    /**
     * @return array<string, string>  locale code => absolute URL
     */
    public static function for(Request $request): array
    {
        $supported = array_keys(config('locales.supported'));
        $route = $request->route();

        if ($route === null) {
            return array_fill_keys($supported, $request->url());
        }

        $name = $route->getName();
        $params = $route->parameters();

        $alternates = [];

        foreach ($supported as $locale) {
            $alternates[$locale] = self::buildUrl($name, $params, $locale, $request);
        }

        return $alternates;
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private static function buildUrl(
        ?string $name,
        array $params,
        string $locale,
        Request $request,
    ): string {
        // Unnamed route (rare — fallback pages): swap the first segment.
        if ($name === null || ! Route::has($name)) {
            $segments = $request->segments();
            $segments[0] = $locale;

            return url(implode('/', $segments));
        }

        $translated = $params;

        foreach ($params as $key => $value) {
            // Route-model-bound parameter that carries per-locale slugs.
            if ($value instanceof HasLocalisedSlugs) {
                $translated[$key] = $value->slugForLocale($locale);

                continue;
            }

            if (is_object($value) && method_exists($value, 'getRouteKey')) {
                $translated[$key] = $value->getRouteKey();
            }
        }

        $translated['locale'] = $locale;

        return route($name, $translated, absolute: true);
    }
}
