<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\SectionType;
use App\Models\Client;
use App\Models\Faq;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\Project;
use App\Models\SectionItem;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Support\IconUrl;
use App\Support\Numerals;
use Illuminate\Support\Collection;

/**
 * Maps Eloquent models onto the DTO shapes declared in
 * resources/js/types/index.ts.
 *
 * Kept as one class so the PHP side and the TypeScript side can be diffed
 * against each other in a single place — if a field is added to a type, the
 * compiler error points here.
 *
 * Every method assumes translations are already eager-loaded by the caller's
 * scope (forListing / withFullDetail / forDisplay). Nothing here triggers a
 * query.
 */
final class ContentTransformer
{
    /* ----------------------------------------------------------- projects */

    /**
     * @return array<string, mixed>
     */
    public static function projectSummary(Project $project): array
    {
        return [
            'slug' => $project->slugForLocale(app()->getLocale()),
            'title' => (string) $project->getTranslation('title'),
            'excerpt' => (string) $project->getTranslation('excerpt'),
            'industry' => (string) ($project->industry?->getTranslation('name') ?? ''),
            'url' => $project->url(absolute: false),

            // Revealed on card hover — Figma "project detail" variant
            // 553:921 ("hover") adds this badge row over 553:936 ("default").
            'services' => $project->relationLoaded('services')
                ? $project->services
                    ->map(fn (Service $s): string => (string) $s->getTranslation('title'))
                    ->all()
                : [],

            'image' => MediaTransformer::make(
                $project->cover_path,
                $project->getTranslation('cover_alt'),
                'project.cover',
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function projectDetail(Project $project): array
    {
        $next = $project->nextProject();

        return array_merge(self::projectSummary($project), [
            // Rendered as a label on the case-study meta row, so it follows the
            // locale's digit system like any other generated number.
            'year' => $project->year === null ? null : Numerals::localise((string) $project->year),
            'instagram' => $project->instagram_handle,
            'services' => $project->services
                ->map(fn (Service $s): string => (string) $s->getTranslation('title'))
                ->all(),

            'challenge' => (string) $project->getTranslation('challenge'),
            'challengePoints' => (array) ($project->getTranslation('challenge_points') ?? []),

            'goals' => self::cardsFor($project, SectionType::Goals),
            'strategy' => self::cardsFor($project, SectionType::Strategy),
            'deliverables' => self::cardsFor($project, SectionType::Deliverables),

            'showcase' => $project->images
                ->map(fn ($image): ?array => MediaTransformer::make(
                    $image->path,
                    $image->getTranslation('alt'),
                    'project.showcase',
                ))
                ->filter()
                ->values()
                ->all(),

            'results' => self::resultsFor($project),
            'resultsSummary' => (string) $project->getTranslation('results_summary'),

            'beforeAfter' => [
                'before' => MediaTransformer::make(
                    $project->before_image_path,
                    null,
                    'project.beforeafter',
                ),
                'after' => MediaTransformer::make(
                    $project->after_image_path,
                    null,
                    'project.beforeafter',
                ),
            ],

            'banner' => MediaTransformer::make(
                $project->banner_path,
                $project->getTranslation('cover_alt'),
                'project.banner',
            ),

            'next' => $next === null ? null : [
                'slug' => $next->slugForLocale(app()->getLocale()),
                'title' => (string) $next->getTranslation('title'),
                'url' => $next->url(absolute: false),
            ],
        ]);
    }

    /* ----------------------------------------------------------- services */

    /**
     * @return array<string, mixed>
     */
    public static function service(Service $service): array
    {
        return [
            /*
             | Locale-independent identity. `slug` is per-locale, so the front
             | end cannot use it to recognise a specific service — the orbit
             | (ServicesOrbit.vue) needs to know *which* service a payload is
             | regardless of the language it is being read in. The fallback
             | locale's slug is the stable name; withTranslations() always
             | eager-loads that row alongside the active one, so this stays a
             | zero-query read.
             */
            'key' => (string) $service->getTranslation('slug', config('locales.fallback')),
            'slug' => (string) $service->getTranslation('slug'),
            'title' => (string) $service->getTranslation('title'),
            'description' => (string) $service->getTranslation('description'),
            'features' => (array) ($service->getTranslation('features') ?? []),
            'homeOrbitGroup' => $service->home_orbit_group,
            'externalUrl' => $service->external_url,
            'icon' => IconUrl::resolve($service->icon),
            'image' => MediaTransformer::make(
                $service->image_path,
                $service->getTranslation('image_alt'),
                'service',
            ),
        ];
    }

    /* -------------------------------------------------------------- posts */

    /**
     * @return array<string, mixed>
     */
    public static function postSummary(Post $post): array
    {
        return [
            'slug' => $post->slugForLocale(app()->getLocale()),
            'title' => (string) $post->getTranslation('title'),
            'excerpt' => (string) $post->getTranslation('excerpt'),
            'url' => $post->url(absolute: false),

            /*
             | Display string in the locale's own format (config/locales.php:
             | en "M d, Y" → "May 09, 2024", fa "Y/m/d", and ar
             | "d F Y" → "09 مايو 2024"). Date digits are handled
             | separately from other generated numbers so Arabic dates remain
             | Latin-digit. The ISO value is deliberately NOT converted — it
             | feeds <time datetime> and must stay machine readable.
             */
            'publishedAt' => Numerals::localiseDate(
                $post->published_at?->translatedFormat(
                    (string) config('locales.supported.'.app()->getLocale().'.date_format', 'M d, Y'),
                ) ?? '',
            ),
            'publishedAtIso' => $post->published_at?->toIso8601String() ?? '',

            // Numeric, so the frontend can pluralise; the locale-formatted
            // string sits beside it for direct rendering.
            'readingTime' => $post->reading_minutes,
            'readingTimeLabel' => Numerals::localiseNumber($post->reading_minutes),
            'category' => $post->category === null ? null : [
                'slug' => (string) $post->category->getTranslation('slug'),
                'name' => (string) $post->category->getTranslation('name'),
            ],
            'image' => MediaTransformer::make(
                $post->cover_path,
                $post->getTranslation('cover_alt'),
                'post.cover',
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function postDetail(Post $post): array
    {
        return array_merge(self::postSummary($post), [
            'subtitle' => (string) $post->getTranslation('subtitle'),
            'content' => (string) $post->getTranslation('content'),
            'image' => MediaTransformer::make(
                $post->cover_path,
                $post->getTranslation('cover_alt'),
                'post.hero',
            ),
            'author' => $post->author === null ? null : [
                'name' => $post->author->name,
                'email' => $post->author->email,
            ],
            'tags' => $post->tags
                ->map(fn ($tag): array => [
                    'slug' => (string) $tag->getTranslation('slug'),
                    'name' => (string) $tag->getTranslation('name'),
                ])
                ->all(),
            'related' => $post->relatedPosts()
                ->map(fn (Post $p): array => self::postSummary($p))
                ->all(),
        ]);
    }

    /* --------------------------------------------------------- components */

    /**
     * @return array<string, mixed>
     */
    public static function teamMember(TeamMember $member): array
    {
        return [
            'name' => (string) $member->getTranslation('name'),
            'role' => (string) $member->getTranslation('role'),
            'image' => MediaTransformer::make(
                $member->photo_path,
                $member->getTranslation('photo_alt'),
                'team',
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function testimonial(Testimonial $testimonial): array
    {
        return [
            'quote' => (string) $testimonial->getTranslation('quote'),
            'name' => (string) $testimonial->getTranslation('author_name'),
            'role' => (string) $testimonial->getTranslation('author_role'),
            'avatar' => MediaTransformer::make(
                $testimonial->avatar_path,
                $testimonial->getTranslation('avatar_alt'),
                'testimonial',
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function faq(Faq $faq): array
    {
        return [
            'question' => (string) $faq->getTranslation('question'),
            'answer' => (string) $faq->getTranslation('answer'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function client(Client $client): array
    {
        return [
            'name' => (string) $client->getTranslation('name'),
            'logo' => MediaTransformer::url($client->logo_path),
            'url' => $client->website_url,
        ];
    }

    /* ----------------------------------------------------------- sections */

    /**
     * Full section payload including its items.
     *
     * @return array<string, mixed>
     */
    public static function section(PageSection $section): array
    {
        return [
            'type' => $section->type->value,
            'eyebrow' => (string) $section->getTranslation('eyebrow'),
            'title' => (string) $section->getTranslation('title'),
            'subtitle' => (string) $section->getTranslation('subtitle'),
            'description' => (string) $section->getTranslation('description'),
            'content' => (string) $section->getTranslation('content'),
            'colors' => [
                'eyebrow' => $section->eyebrow_color,
                'title' => $section->title_color,
                'subtitle' => $section->subtitle_color,
                'description' => $section->description_color,
                'content' => $section->content_color,
            ],
            'primaryCta' => self::cta(
                $section->getTranslation('primary_cta_label'),
                $section->getTranslation('primary_cta_url'),
                $section->primary_cta_icon,
            ),
            'secondaryCta' => self::cta(
                $section->getTranslation('secondary_cta_label'),
                $section->getTranslation('secondary_cta_url'),
                $section->secondary_cta_icon,
            ),
            'image' => MediaTransformer::make(
                $section->image_path,
                $section->getTranslation('image_alt'),
                self::imageContextFor($section->type),
            ),
            'items' => $section->items
                ->map(fn (SectionItem $item): array => self::sectionItem($item))
                ->all(),
        ];
    }

    /**
     * Keyed map of every visible section on a page, so a Vue page can read
     * `sections.hero` instead of searching an array.
     *
     * @param  Collection<int, PageSection>  $sections
     * @return array<string, array<string, mixed>>
     */
    public static function sectionMap(Collection $sections): array
    {
        return $sections
            ->mapWithKeys(fn (PageSection $s): array => [
                $s->type->value => self::section($s),
            ])
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public static function sectionItem(SectionItem $item): array
    {
        return [
            'id' => $item->getKey(),
            'value' => (string) $item->getTranslation('value'),
            'label' => (string) $item->getTranslation('label'),
            'suffix' => (string) $item->getTranslation('suffix'),
            'title' => (string) $item->getTranslation('title'),
            'description' => (string) $item->getTranslation('description'),
            'badge' => (string) $item->getTranslation('badge'),
            'features' => (array) ($item->getTranslation('features') ?? []),
            'footer' => (string) $item->getTranslation('footer'),
            'icon' => IconUrl::resolve($item->icon),
            'image' => MediaTransformer::make(
                $item->image_path,
                $item->getTranslation('image_alt'),
                'section',
            ),
        ];
    }

    /* ------------------------------------------------------------ helpers */

    /**
     * CardItem[] — title + description only. Used for goals, strategy,
     * deliverables and the why-us / how-we-think grids.
     *
     * @return array<int, array{title: string, description: string}>
     */
    private static function cardsFor(Project $project, SectionType $type): array
    {
        $section = $project->section($type);

        if ($section === null) {
            return [];
        }

        return $section->items
            ->map(fn (SectionItem $item): array => [
                'title' => (string) $item->getTranslation('title'),
                'description' => (string) $item->getTranslation('description'),
            ])
            ->all();
    }

    /**
     * ResultStat[] — label + value + optional uploaded icon.
     *
     * @return array<int, array{label: string, value: string, icon: string|null}>
     */
    private static function resultsFor(Project $project): array
    {
        $section = $project->section(SectionType::Results);

        if ($section === null) {
            return [];
        }

        return $section->items
            ->map(fn (SectionItem $item): array => [
                'label' => (string) $item->getTranslation('title'),
                'value' => (string) $item->getTranslation('value'),
                'icon' => IconUrl::resolve($item->icon),
            ])
            ->all();
    }

    /**
     * @return array{label: string, url: string, icon: string|null}|null
     */
    private static function cta(?string $label, ?string $url, ?string $icon = null): ?array
    {
        if ($label === null || $label === '') {
            return null;
        }

        return ['label' => $label, 'url' => $url ?? '#', 'icon' => IconUrl::resolve($icon)];
    }

    private static function imageContextFor(SectionType $type): string
    {
        return match ($type) {
            SectionType::Hero => 'page.hero',
            SectionType::AboutHero => 'page.about',
            default => 'section',
        };
    }
}
