<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Support\CanonicalUrl;
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
    public static function forPage(?Page $page, string $canonical, ?string $image = null, bool $noindex = false): array
    {
        $query = request()->only(['page', 'category', 'q', 'service']);
        $query = array_filter($query, fn ($value, $key) => is_scalar($value) && (string) $value !== '' && ($key !== 'page' || (int) $value > 1), ARRAY_FILTER_USE_BOTH);
        $canonical = CanonicalUrl::for($canonical).($query ? '?'.http_build_query($query) : '');

        return self::assemble(
            title: $page?->getTranslation('seo_title') ?: $page?->getTranslation('title'),
            description: $page?->getTranslation('seo_description') ?: $page?->getTranslation('description'),
            image: $image,
            canonical: $canonical,
            type: 'website',
            noindex: $noindex,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function forProject(Project $project): array
    {
        $seo = self::assemble(
            title: $project->getTranslation('seo_title') ?: $project->getTranslation('title'),
            description: $project->getTranslation('seo_description') ?: $project->getTranslation('excerpt'),
            image: $project->cover_path === null
                ? null
                : MediaTransformer::url($project->cover_path),
            canonical: CanonicalUrl::for($project->url()),
            type: 'website',
        );
        $seo['structuredData'][] = array_filter([
            '@context' => 'https://schema.org', '@type' => 'CreativeWork',
            'name' => (string) $project->getTranslation('title'),
            'description' => (string) $project->getTranslation('excerpt'),
            'url' => $seo['canonical'], 'image' => $seo['image'],
            'inLanguage' => config('locales.supported.'.app()->getLocale().'.html_lang'),
            'creator' => ['@id' => CanonicalUrl::origin().'/#organization'],
        ], fn ($value) => $value !== null && $value !== '');

        return $seo;
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
            canonical: CanonicalUrl::for($post->url()),
            type: 'article',
            publishedAt: $post->published_at?->toIso8601String(),
            modifiedAt: collect([$post->updated_at, $post->translate()?->updated_at])->filter()->max()?->toIso8601String(),
            author: $post->author?->name,
            headline: (string) $post->getTranslation('title'),
        );
    }

    public static function forError(int $status): array
    {
        $key = in_array($status, [403, 404, 429, 500, 503], true) ? $status : 500;

        return [
            'title' => __("errors.{$key}.title"),
            'description' => __("errors.{$key}.message"),
            'canonical' => null, 'image' => null, 'type' => 'website',
            'noindex' => true, 'structuredData' => [],
            'ogLocale' => config('locales.supported.'.app()->getLocale().'.locale'),
        ];
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
        ?string $headline = null,
    ): array {
        $locale = app()->getLocale();

        $settings = SiteSettings::forFrontend($locale);
        $title = $title ?: $settings['seo']['defaultTitle'];
        $description = trim(strip_tags($description ?: $settings['seo']['defaultDescription']));
        $image = $image ?: $settings['seo']['defaultImage'];
        if ($image && ! preg_match('~^https?://~i', $image)) {
            $image = CanonicalUrl::origin().'/'.ltrim($image, '/');
        }
        $origin = CanonicalUrl::origin();
        $organization = [
            '@context' => 'https://schema.org', '@type' => 'Organization',
            '@id' => $origin.'/#organization', 'name' => $settings['seo']['organizationName'],
            'url' => $origin.'/', 'sameAs' => array_column($settings['socialLinks'], 'url'),
        ];
        foreach (['email' => 'email', 'phone' => 'telephone'] as $key => $property) {
            if (filled($settings['contact'][$key])) {
                $organization[$property] = $settings['contact'][$key];
            }
        }
        $structuredData = [$organization, [
            '@context' => 'https://schema.org', '@type' => 'WebSite',
            '@id' => $origin.'/#website', 'name' => $settings['siteName'], 'url' => $origin.'/',
        ]];
        if ($type === 'article') {
            $article = [
                '@context' => 'https://schema.org', '@type' => 'Article',
                'headline' => $headline ?: $title, 'description' => $description,
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
                'inLanguage' => config("locales.supported.{$locale}.html_lang"),
                'publisher' => ['@id' => $origin.'/#organization'],
                'author' => $author ? ['@type' => 'Person', 'name' => $author] : ['@id' => $origin.'/#organization'],
            ];
            if ($image) {
                $article['image'] = [$image];
            }
            if ($publishedAt) {
                $article['datePublished'] = $publishedAt;
            }
            if ($modifiedAt) {
                $article['dateModified'] = $modifiedAt;
            }
            $structuredData[] = $article;
        }

        return [
            'title' => $title ?: SiteSettings::get('seo_default_title', $locale, 'Sahra'),
            'description' => $description
                ?: SiteSettings::get('seo_default_description', $locale, ''),
            'image' => $image,
            'structuredData' => $structuredData,
            'ogLocale' => config("locales.supported.{$locale}.locale"),
            'canonical' => $canonical,
            'type' => $type,
            'publishedAt' => $publishedAt,
            'modifiedAt' => $modifiedAt,
            'author' => $author,
            'noindex' => $noindex,
        ];
    }
}
