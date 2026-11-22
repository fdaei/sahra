<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Support\SeoCanonical;
use App\Support\SiteSettings;

/** A concise editorial status, not an indexing or ranking guarantee. */
final class ContentSeoStatus
{
    public static function for(Page|Post|Project $model, string $locale): string
    {
        $model->loadMissing('translations');
        $translation = $model->translations->firstWhere('locale', $locale);
        if ($translation === null) {
            return 'missing_translation';
        }
        if (($model instanceof Post || $model instanceof Project) && blank($translation->slug)) {
            return 'missing_url';
        }
        if ((bool) $translation->seo_noindex) {
            return 'noindex';
        }
        if (! SeoCanonical::isSelfCanonical($model, $locale)) {
            return 'canonical_elsewhere';
        }
        $title = $translation->seo_title ?: $translation->title ?: SiteSettings::get('seo_default_title', $locale, 'Sahra');
        if (blank($title)) {
            return 'missing_title';
        }
        $summary = $model instanceof Page ? $translation->description : $translation->excerpt;
        $description = $translation->seo_description ?: $summary ?: SiteSettings::get('seo_default_description', $locale, '');
        if (blank(trim(strip_tags((string) $description)))) {
            return 'missing_description';
        }
        return 'metadata_present';
    }

    public static function label(string $status): string
    {
        return __(match ($status) {
            'missing_translation' => 'Translation missing',
            'missing_url' => 'Localized URL missing',
            'noindex' => 'Noindex enabled',
            'canonical_elsewhere' => 'Canonical points elsewhere',
            'missing_title' => 'Search title missing',
            'missing_description' => 'Search description missing',
            default => 'Search metadata present',
        });
    }
}
