<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ArticleSchemaType;
use App\Models\Page;
use App\Services\Seo\SocialImageMetadata;
use App\Models\Post;
use App\Models\Project;
use App\Support\Breadcrumbs;
use App\Support\CanonicalUrl;
use App\Support\SeoCanonical;
use App\Support\SeoRobots;
use App\Support\SiteSettings;
use App\Support\SeoVisibility;

/**
 * Builds the SeoMeta payload consumed by resources/js/Components/SeoHead.vue.
 *
 * Falls back through: entity SEO override -> entity title/excerpt ->
 * site defaults. Editors may override the canonical URL per locale.
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
        if ($query === []) {
            $canonical = SeoCanonical::override($page) ?? $canonical;
        }

        $seo = self::assemble(
            title: $page?->getTranslation('seo_title') ?: $page?->getTranslation('title'),
            description: $page?->getTranslation('seo_description') ?: $page?->getTranslation('description'),
            image: $image,
            canonical: $canonical,
            type: 'website',
            noindex: $noindex || SeoVisibility::noindex($page),
            nofollow: SeoVisibility::nofollow($page),
            indexableLocales: SeoVisibility::indexableLocales($page),
            robots: SeoRobots::render($page, $noindex || SeoVisibility::noindex($page), SeoVisibility::nofollow($page)),
            socialTitle: $page?->getTranslation('seo_social_title'),
            socialDescription: $page?->getTranslation('seo_social_description'),
            socialImage: $page?->getTranslation('seo_social_image'),
            socialImageAlt: $page?->getTranslation('seo_social_image_alt'),
            twitterTitle: $page?->getTranslation('seo_twitter_title'),
            twitterDescription: $page?->getTranslation('seo_twitter_description'),
            twitterImage: $page?->getTranslation('seo_twitter_image'),
            twitterImageAlt: $page?->getTranslation('seo_twitter_image_alt'),
            twitterCard: $page?->getTranslation('seo_twitter_card'),
            imagePath: $image,
        );

        // Home › Page. Pages needing a deeper trail re-attach their own.
        if ($page !== null && $page->key !== 'home') {
            $seo = Breadcrumbs::attach($seo, [
                Breadcrumbs::home(),
                Breadcrumbs::crumb((string) $page->getTranslation('title'), '/'.ltrim(request()->path(), '/')),
            ]);
        }

        return $seo;
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
            canonical: SeoCanonical::override($project) ?? CanonicalUrl::for($project->url()),
            type: 'website',
            noindex: SeoVisibility::noindex($project),
            nofollow: SeoVisibility::nofollow($project),
            indexableLocales: SeoVisibility::indexableLocales($project),
            robots: SeoRobots::render($project, SeoVisibility::noindex($project), SeoVisibility::nofollow($project)),
            socialTitle: $project->getTranslation('seo_social_title'),
            socialDescription: $project->getTranslation('seo_social_description'),
            socialImage: $project->getTranslation('seo_social_image'),
            socialImageAlt: $project->getTranslation('seo_social_image_alt'),
            twitterTitle: $project->getTranslation('seo_twitter_title'),
            twitterDescription: $project->getTranslation('seo_twitter_description'),
            twitterImage: $project->getTranslation('seo_twitter_image'),
            twitterImageAlt: $project->getTranslation('seo_twitter_image_alt'),
            twitterCard: $project->getTranslation('seo_twitter_card'),
            imagePath: $project->cover_path,
            imageAlt: $project->getTranslation('cover_alt'),
        );
        $seo = self::withCoverSchema($seo, $project->cover_path);
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
        return self::withCoverSchema(self::assemble(
            title: $post->getTranslation('seo_title') ?: $post->getTranslation('title'),
            description: $post->getTranslation('seo_description') ?: $post->getTranslation('excerpt'),
            image: $post->cover_path === null
                ? null
                : MediaTransformer::url($post->cover_path),
            canonical: SeoCanonical::override($post) ?? CanonicalUrl::for($post->url()),
            type: 'article',
            publishedAt: $post->published_at?->toIso8601String(),
            modifiedAt: collect([$post->updated_at, $post->translate()?->updated_at])->filter()->max()?->toIso8601String(),
            author: $post->author?->name,
            headline: (string) $post->getTranslation('title'),
            noindex: SeoVisibility::noindex($post),
            nofollow: SeoVisibility::nofollow($post),
            indexableLocales: SeoVisibility::indexableLocales($post),
            robots: SeoRobots::render($post, SeoVisibility::noindex($post), SeoVisibility::nofollow($post)),
            socialTitle: $post->getTranslation('seo_social_title'),
            socialDescription: $post->getTranslation('seo_social_description'),
            socialImage: $post->getTranslation('seo_social_image'),
            socialImageAlt: $post->getTranslation('seo_social_image_alt'),
            twitterTitle: $post->getTranslation('seo_twitter_title'),
            twitterDescription: $post->getTranslation('seo_twitter_description'),
            twitterImage: $post->getTranslation('seo_twitter_image'),
            twitterImageAlt: $post->getTranslation('seo_twitter_image_alt'),
            twitterCard: $post->getTranslation('seo_twitter_card'),
            imagePath: $post->cover_path,
            imageAlt: $post->getTranslation('cover_alt'),
            articleSchemaType: ArticleSchemaType::tryFrom((string) $post->seo_schema_type) ?? ArticleSchemaType::Article,
        ), $post->cover_path);
    }

    /**
     * Add the cover's Media-library ImageObject (title, caption, alt as
     * description, credit, dimensions) when the file is in the library.
     *
     * @param  array<string, mixed>  $seo
     * @return array<string, mixed>
     */
    private static function withCoverSchema(array $seo, ?string $path): array
    {
        if ($path === null || $path === '') {
            return $seo;
        }

        $node = \App\Models\Media::query()->where('path', ltrim($path, '/'))->with('translations')->first()?->schema();
        if ($node !== null) {
            $seo['structuredData'][] = $node;
        }

        return $seo;
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
        bool $nofollow = false,
        ?array $indexableLocales = null,
        ?string $socialTitle = null,
        ?string $socialDescription = null,
        ?string $socialImage = null,
        ?string $socialImageAlt = null,
        ?string $twitterTitle = null,
        ?string $twitterDescription = null,
        ?string $twitterImage = null,
        ?string $twitterImageAlt = null,
        ?string $twitterCard = null,
        ?string $imagePath = null,
        ?string $imageAlt = null,
        ArticleSchemaType $articleSchemaType = ArticleSchemaType::Article,
        ?string $robots = null,
    ): array {
        $locale = app()->getLocale();

        $settings = SiteSettings::forFrontend($locale);
        $title = $title ?: $settings['seo']['defaultTitle'];
        $description = trim(strip_tags($description ?: $settings['seo']['defaultDescription']));
        if (filled($socialImage)) {
            $chosenPath = $socialImage;
            $chosenAlt = $socialImageAlt;
        } elseif (filled($image)) {
            $chosenPath = $imagePath;
            $chosenAlt = $socialImageAlt ?: $imageAlt;
        } else {
            $chosenPath = SiteSettings::get('seo_default_image', $locale);
            $chosenAlt = $socialImageAlt ?: SiteSettings::get('seo_default_image_alt', $locale);
        }
        $socialMetadata = SocialImageMetadata::for(is_string($chosenPath) ? $chosenPath : null, is_string($chosenAlt) ? $chosenAlt : null, $locale);
        $image = $image ?: $settings['seo']['defaultImage'];
        if ($image && ! preg_match('~^https?://~i', $image)) {
            $image = CanonicalUrl::origin().'/'.ltrim($image, '/');
        }
        if (filled($socialImage)) {
            $socialImage = MediaTransformer::url($socialImage);
            if (! preg_match('~^https?://~i', $socialImage)) {
                $socialImage = CanonicalUrl::origin().'/'.ltrim($socialImage, '/');
            }
        }
        $resolvedSocialImage = $socialImage ?: $image;
        if (filled($twitterImage)) {
            $twitterMetadata = SocialImageMetadata::for($twitterImage, $twitterImageAlt, $locale);
            $twitterImage = MediaTransformer::url($twitterImage);
            if (! preg_match('~^https?://~i', $twitterImage)) {
                $twitterImage = CanonicalUrl::origin().'/'.ltrim($twitterImage, '/');
            }
            $resolvedTwitterAlt = $twitterMetadata['alt'];
        } else {
            $twitterImage = $resolvedSocialImage;
            $resolvedTwitterAlt = filled($twitterImageAlt) ? trim($twitterImageAlt) : $socialMetadata['alt'];
        }
        $resolvedTwitterCard = in_array($twitterCard, ['summary', 'summary_large_image'], true)
            ? $twitterCard : ($twitterImage ? 'summary_large_image' : 'summary');
        if (! $twitterImage && $resolvedTwitterCard === 'summary_large_image') {
            $resolvedTwitterCard = 'summary';
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
        if ($type === 'article' && $articleSchemaType !== ArticleSchemaType::None) {
            $article = [
                '@context' => 'https://schema.org', '@type' => $articleSchemaType->value,
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
            'socialTitle' => $socialTitle ?: $title,
            'socialDescription' => filled($socialDescription) ? trim(strip_tags($socialDescription)) : $description,
            'socialImage' => $resolvedSocialImage,
            'twitterTitle' => $twitterTitle ?: ($socialTitle ?: $title),
            'twitterDescription' => filled($twitterDescription) ? trim(strip_tags($twitterDescription)) : (filled($socialDescription) ? trim(strip_tags($socialDescription)) : $description),
            'twitterImage' => $twitterImage,
            'twitterImageAlt' => $resolvedTwitterAlt,
            'twitterCard' => $resolvedTwitterCard,
            'socialImageAlt' => $socialMetadata['alt'],
            'socialImageWidth' => $socialMetadata['width'],
            'socialImageHeight' => $socialMetadata['height'],
            'socialImageMime' => $socialMetadata['mime'],
            'structuredData' => $structuredData,
            'ogLocale' => config("locales.supported.{$locale}.locale"),
            'canonical' => $canonical,
            'type' => $type,
            'publishedAt' => $publishedAt,
            'modifiedAt' => $modifiedAt,
            'author' => $author,
            'noindex' => $noindex,
            'robots' => $robots,
            'nofollow' => $nofollow,
            'indexableLocales' => $indexableLocales,
        ];
    }
}
