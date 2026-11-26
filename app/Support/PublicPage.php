<?php

declare(strict_types=1);

namespace App\Support;

final class PublicPage
{
    public static function oldText(string $name): string
    {
        $value = old($name);

        return is_string($value) ? $value : '';
    }

    /** Repeat both halves of a scrolling track so it stays filled on wide screens. */
    public static function marquee(array $items, int $itemWidth): array
    {
        if ($items === []) {
            return [];
        }

        $repeats = (int) ceil(2560 / ($itemWidth * count($items)));

        return array_merge(...array_fill(0, 2 * $repeats, $items));
    }

    /** Expand just the selected branch of the category tree. */
    public static function categoryFilters(array $categories, ?string $active): array
    {
        $categoriesBySlug = array_column($categories, null, 'slug');
        $open = [];
        for ($slug = $active; $slug !== null && ! isset($open[$slug]); $slug = $categoriesBySlug[$slug]['parent'] ?? null) {
            $open[$slug] = true;
        }

        $byParent = [];
        foreach ($categories as $category) {
            $parent = $category['parent'];
            $byParent[isset($categoriesBySlug[$parent]) ? $parent : ''][] = $category;
        }

        $items = [];
        $walk = function (string $parent, int $depth) use (&$walk, &$items, $byParent, $open): void {
            foreach ($byParent[$parent] ?? [] as $category) {
                $items[] = [...$category, 'depth' => $depth];
                if (isset($open[$category['slug']]) && $depth < 10) {
                    $walk($category['slug'], $depth + 1);
                }
            }
        };
        $walk('', 0);

        return $items;
    }

    /** A null entry marks where the signup belongs in the article. */
    public static function articleParts(string $html, bool $hasSignup): array
    {
        $parts = preg_split('~<(p|div)>\s*\[\[lead_magnet\]\]\s*</\1>|\[\[lead_magnet\]\]~i', $html);

        if (! $hasSignup) {
            return [implode('', $parts)];
        }

        if (count($parts) > 1) {
            return [$parts[0], null, implode('', array_slice($parts, 1))];
        }

        if (strlen($html) >= 1200) {
            preg_match_all('/<h[23][\s>]/i', $html, $headings, PREG_OFFSET_CAPTURE);
            foreach ($headings[0] as [, $position]) {
                if ($position > strlen($html) / 2) {
                    return [substr($html, 0, $position), null, substr($html, $position)];
                }
            }
        }

        return [$html, null];
    }
}
