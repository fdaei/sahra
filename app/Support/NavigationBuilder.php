<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;

/**
 * Builds the header and footer navigation trees.
 *
 * Menu items may either point at a named route (route_name + optional
 * route_params) or an arbitrary URL. Route-backed items are resolved through
 * route() so they automatically carry the active locale prefix.
 *
 * Figma reference:
 *   header  1419:9339  — Home / Work / Service / Insight / About + Book Consultation
 *   footer  1419:9317  — Quick Links / Social Links / Info columns
 */
final class NavigationBuilder
{
    private const TTL = 86400;

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function header(string $locale): array
    {
        return self::build('header', $locale);
    }

    /**
     * Footer menus are grouped into named columns (Quick Links, Social Links,
     * Info) — each top-level item is a column heading, its children are links.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function footer(string $locale): array
    {
        return self::build('footer', $locale);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function build(string $location, string $locale): array
    {
        return Cache::remember(
            "nav.{$location}.{$locale}",
            self::TTL,
            function () use ($location, $locale): array {
                $menu = Menu::query()
                    ->where('location', $location)
                    ->with(['items' => fn ($q) => $q
                        ->where('is_active', true)
                        ->orderBy('sort_order'),
                    ])
                    ->first();

                if ($menu === null) {
                    return [];
                }

                return $menu->items
                    ->whereNull('parent_id')
                    ->map(fn (MenuItem $item): array => self::transform($item, $menu->items, $locale))
                    ->values()
                    ->all();
            },
        );
    }

    /**
     * @param  \Illuminate\Support\Collection<int, MenuItem>  $all
     * @return array<string, mixed>
     */
    private static function transform(MenuItem $item, $all, string $locale): array
    {
        $children = $all
            ->where('parent_id', $item->id)
            ->map(fn (MenuItem $child): array => self::transform($child, $all, $locale))
            ->values()
            ->all();

        return [
            'id'       => $item->id,
            'label'    => $item->getTranslation('label', $locale),
            'url'      => $item->resolveUrl($locale),
            'target'   => $item->target,
            'isCta'    => $item->is_cta,
            'children' => $children,
        ];
    }

    public static function flush(): void
    {
        foreach (array_keys(config('locales.supported')) as $locale) {
            Cache::forget("nav.header.{$locale}");
            Cache::forget("nav.footer.{$locale}");
        }
    }
}
