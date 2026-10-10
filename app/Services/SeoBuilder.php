<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Support\CanonicalUrl;
use App\Support\SiteSettings;

/**
 * Builds the SeoMeta payload consumed by resources/js/Components/SeoHead.vue
 * and, when the SSR renderer is unavailable, by
 * resources/views/seo/head.blade.php.
 *
 * Falls back through: entity SEO override -> entity title/excerpt ->
 * site defaults. Canonical is always the absolute URL of the current locale's
 * version of the page.
 *
 * JSON-LD is assembled here rather than in Vue so the Blade fallback and the
 * client render emit identical structured data from one source.
 */
final class SeoBuilder
{
    /**
     * Shipped share image, used until an editor sets one in Site settings.
     */
    private const FALLBACK_IMAGE = '/images/sahra/hero-brand-preview.png';

    /**
     * @return array<string, mixed>
     */
    public static function forPage(?Page $page, string $canonical, ?string $image = null, bool $noindex = false): array
    {
        return self::assemble(
            title: $page?->getTranslation('seo_title') ?: $page?->getTranslation('title'),
            description: $page?->getTranslation('seo_description') ?: $page?->getTranslation('description'),
            image: $image,
            canonical: CanonicalUrl::for($canonical),
            type: 'website',
            noindex: $noindex,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function forProject(Project $project): array
    {
        $canonical = CanonicalUrl::for($project->url());

        return self::assemble(
            title: $project->getTranslation('seo_title') ?: $project->getTranslation('title'),
            description: $project->getTranslation('seo_description') ?: $project->getTranslation('excerpt'),
            image: $project->cover_path === null
                ? null
                : MediaTransformer::url($project->cover_path),
            canonical: $canonical,
            type: 'website',
            breadcrumbs: [
                ['name' => __('common.projects'), 'url' => CanonicalUrl::route('work.index')],
                ['name' => (string) $project->getTranslation('title'), 'url' => $canonical],
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function forPost(Post $post): array
    {
        $canonical = CanonicalUrl::for($post->url());

        return self::assemble(
            title: $post->getTranslation('seo_title') ?: $post->getTranslation('title'),
            description: $post->getTranslation('seo_description') ?: $post->getTranslation('excerpt'),
            image: $post->cover_path === null
                ? null
                : MediaTransformer::url($post->cover_path),
            canonical: $canonical,
            type: 'article',
            publishedAt: $post->published_at?->toIso8601String(),
            modifiedAt: $post->updated_at?->toIso8601String(),
            author: $post->author?->name,
            breadcrumbs: [
                ['name' => __('common.insights'), 'url' => CanonicalUrl::route('insights.index')],
                ['name' => (string) $post->getTranslation('title'), 'url' => $canonical],
            ],
        );
    }

    /**
     * Appends the site name so every result is branded, unless the title
     * already carries it (the seeded home title is "Sahra — …").
     */
    public static function brandTitle(string $title, string $siteName): string
    {
        if ($siteName === '' || mb_stripos($title, $siteName) !== false) {
            return $title;
        }

        return "{$title} | {$siteName}";
    }

    /**
     * @param  list<array{name: string, url: string}>  $breadcrumbs  trail after Home
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
        array $breadcrumbs = [],
    ): array {
        $locale = app()->getLocale();
        $settings = SiteSettings::forFrontend($locale);

        $headline = (string) ($title ?: $settings['seo']['defaultTitle']);

        $meta = [
            'title' => self::brandTitle($headline, (string) $settings['siteName']),
            'description' => (string) ($description ?: $settings['seo']['defaultDescription']),
            'image' => self::absolute($image ?: $settings['seo']['defaultImage'] ?: self::FALLBACK_IMAGE),
            'canonical' => $canonical,
            'type' => $type,
            'publishedAt' => $publishedAt,
            'modifiedAt' => $modifiedAt,
            'author' => $author,
            'noindex' => $noindex,
        ];

        $meta['jsonLd'] = self::structuredData($meta, $headline, $settings, $locale, $breadcrumbs);

        return $meta;
    }

    /**
     * The public disk serves root-relative URLs (/storage/…), but og:image,
     * twitter:image and JSON-LD images are only honoured when absolute.
     */
    private static function absolute(string $url): string
    {
        return str_starts_with($url, '/') && ! str_starts_with($url, '//')
            ? CanonicalUrl::origin().$url
            : $url;
    }

    /**
     * Organization + WebSite on every page, Article on posts, BreadcrumbList
     * on detail pages.
     *
     * @param  array<string, mixed>  $meta
     * @param  array<string, mixed>  $settings
     * @param  list<array{name: string, url: string}>  $breadcrumbs
     * @return list<array<string, mixed>>
     */
    private static function structuredData(array $meta, string $headline, array $settings, string $locale, array $breadcrumbs): array
    {
        $home = CanonicalUrl::route('home', ['locale' => $locale]);
        $htmlLang = (string) config("locales.supported.{$locale}.html_lang", $locale);
        $organizationName = (string) $settings['seo']['organizationName'];
        $logo = CanonicalUrl::origin().'/icon-512.png';
        $contact = $settings['contact'];
        $notNull = fn (mixed $value): bool => $value !== null;

        $graph = [
            array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => $home.'#organization',
                'name' => $organizationName,
                'url' => $home,
                'logo' => $logo,
                'email' => $contact['email'] ?: null,
                'telephone' => $contact['phone'] ?: null,
                'address' => $contact['location']
                    ? ['@type' => 'PostalAddress', 'addressLocality' => $contact['location']]
                    : null,
                'sameAs' => array_values(array_filter(array_column($settings['socialLinks'], 'url'))) ?: null,
            ], $notNull),
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => $home.'#website',
                'name' => (string) $settings['siteName'],
                'url' => $home,
                'inLanguage' => $htmlLang,
                'publisher' => ['@id' => $home.'#organization'],
            ],
        ];

        if ($meta['type'] === 'article') {
            $graph[] = array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => $headline,
                'description' => $meta['description'] ?: null,
                'image' => [$meta['image']],
                'datePublished' => $meta['publishedAt'],
                'dateModified' => $meta['modifiedAt'] ?? $meta['publishedAt'],
                'author' => $meta['author']
                    ? ['@type' => 'Person', 'name' => $meta['author']]
                    : ['@type' => 'Organization', 'name' => $organizationName],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $organizationName,
                    'logo' => ['@type' => 'ImageObject', 'url' => $logo],
                ],
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $meta['canonical']],
                'inLanguage' => $htmlLang,
            ], $notNull);
        }

        if ($breadcrumbs !== []) {
            $trail = [['name' => (string) $settings['siteName'], 'url' => $home], ...$breadcrumbs];

            $graph[] = [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => array_map(
                    fn (array $crumb, int $index): array => [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'name' => $crumb['name'],
                        'item' => $crumb['url'],
                    ],
                    $trail,
                    array_keys($trail),
                ),
            ];
        }

        return $graph;
    }
}
