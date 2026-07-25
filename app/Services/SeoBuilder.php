<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Support\SiteSettings;

/**
 * Builds the SeoMeta payload consumed by resources/js/Components/SeoHead.vue.
 *
 * Falls back through: entity SEO override -> entity title/excerpt ->
 * site defaults. Canonical is always the absolute URL of the current locale's
 * version of the page.
 */
final class SeoBuilder
{
    /**
     * @return array<string, mixed>
     */
    public static function forPage(?Page $page, string $canonical, ?string $image = null): array
    {
        return self::assemble(
            title: $page?->getTranslation('seo_title') ?: $page?->getTranslation('title'),
            description: $page?->getTranslation('seo_description') ?: $page?->getTranslation('description'),
            image: $image,
            canonical: $canonical,
            type: 'website',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function forProject(Project $project): array
    {
        return self::assemble(
            title: $project->getTranslation('seo_title') ?: $project->getTranslation('title'),
            description: $project->getTranslation('seo_description') ?: $project->getTranslation('excerpt'),
            image: $project->cover_path === null
                ? null
                : MediaTransformer::url($project->cover_path),
            canonical: $project->url(),
            type: 'website',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function forPost(Post $post): array
    {
        return self::assemble(
            title: $post->getTranslation('seo_title') ?: $post->getTranslation('title'),
            description: $post->getTranslation('seo_description') ?: $post->getTranslation('excerpt'),
            image: $post->cover_path === null
                ? null
                : MediaTransformer::url($post->cover_path),
            canonical: $post->url(),
            type: 'article',
            publishedAt: $post->published_at?->toIso8601String(),
            modifiedAt: $post->updated_at?->toIso8601String(),
            author: $post->author?->name,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private static function assemble(
        ?string $title,
        ?string $description,
        ?string $image,
        string $canonical,
        string $type,
        ?string $publishedAt = null,
        ?string $modifiedAt = null,
        ?string $author = null,
        bool $noindex = false,
    ): array {
        $locale = app()->getLocale();

        return [
            'title' => $title ?: SiteSettings::get('seo_default_title', $locale, 'Sahra'),
            'description' => $description
                ?: SiteSettings::get('seo_default_description', $locale, ''),
            'image' => $image,
            'canonical' => $canonical,
            'type' => $type,
            'publishedAt' => $publishedAt,
            'modifiedAt' => $modifiedAt,
            'author' => $author,
            'noindex' => $noindex,
        ];
    }
}
