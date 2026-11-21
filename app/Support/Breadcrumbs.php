<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\PostCategory;

/**
 * Breadcrumb trails — one source for both the visible trail
 * (resources/js/Components/Breadcrumbs.vue, via `seo.breadcrumbs`) and the
 * BreadcrumbList JSON-LD, so the two never disagree.
 *
 * A crumb is ['name', 'href' (relative, for Inertia links), 'url' (absolute
 * canonical, for schema)]. The last crumb is the current page.
 */
final class Breadcrumbs
{
    /** @return array{name:string, href:string, url:string} */
    public static function crumb(string $name, string $href): array
    {
        $path = (string) (parse_url($href, PHP_URL_PATH) ?: '/');
        $query = parse_url($href, PHP_URL_QUERY);
        $suffix = $query ? '?'.$query : '';

        return [
            'name' => trim(strip_tags($name)),
            'href' => $path.$suffix,
            'url' => CanonicalUrl::for($path).$suffix,
        ];
    }

    /** @return array{name:string, href:string, url:string} */
    public static function home(): array
    {
        return self::crumb(__('common.breadcrumb_home'), route('home', absolute: false));
    }

    /** @return array{name:string, href:string, url:string} */
    public static function route(string $name, string $routeName): array
    {
        return self::crumb($name, route($routeName, absolute: false));
    }

    /**
     * A category and its ancestors, each linking to the filtered listing.
     *
     * @return list<array{name:string, href:string, url:string}>
     */
    public static function category(PostCategory $category): array
    {
        return array_map(
            fn (PostCategory $c): array => self::crumb((string) $c->getTranslation('name'), $c->listingUrl()),
            [...$category->ancestors(), $category],
        );
    }

    /**
     * Put the trail on an SEO payload and replace any BreadcrumbList node
     * with one built from the same trail.
     *
     * @param  array<string, mixed>  $seo
     * @param  list<array{name:string, href:string, url:string}>  $trail
     * @return array<string, mixed>
     */
    public static function attach(array $seo, array $trail): array
    {
        $seo['breadcrumbs'] = $trail;

        $nodes = array_values(array_filter(
            $seo['structuredData'] ?? [],
            fn (array $node): bool => ($node['@type'] ?? null) !== 'BreadcrumbList',
        ));

        if (count($trail) > 1) {
            $nodes[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => array_map(
                    fn (array $c, int $i): array => ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $c['name'], 'item' => $c['url']],
                    $trail,
                    array_keys($trail),
                ),
            ];
        }

        $seo['structuredData'] = $nodes;

        return $seo;
    }
}
