<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Models\InternalLink;
use App\Support\SiteSettings;

final class ArticleAutoLinks
{
    public static function render(string $html, string $locale, string $selfUrl): string
    {
        if (trim($html) === '' || ! SiteSettings::get('seo_autolink_enabled', default: true)) {
            return $html;
        }
        $rules = array_values(array_filter(InternalLink::rulesFor($locale), static fn (array $rule): bool =>
            \App\Support\InternalPath::valid($rule['url'])));
        if ($rules === []) {
            return $html;
        }
        $fragment = new HtmlFragment($html);
        AutoLinker::apply($fragment, $rules, $selfUrl, max(1, min(20, (int) SiteSettings::get('seo_autolink_max_total', default: 5))));

        return $fragment->html();
    }
}
