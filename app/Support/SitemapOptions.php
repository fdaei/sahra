<?php

declare(strict_types=1);

namespace App\Support;

final class SitemapOptions
{
    public static function enabled(string $type): bool
    {
        if (! in_array($type, ['pages', 'posts', 'projects', 'images'], true)) {
            return false;
        }

        return (bool) SiteSettings::get('sitemap_'.$type, default: true);
    }
}
