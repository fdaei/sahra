<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasLocalisedSlugs;
use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Models\Translations\ProjectTranslation;
use App\Traits\HasTranslations;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A case study.
 *
 * Figma: listing card 1362:7211, detail page 1323:7541.
 *
 * Detail content (goals, strategy, deliverables, results) is stored as
 * PageSections attached polymorphically, so the Goal/Strategy card components
 * and the Filament relation manager are shared with Page.
 */
final class Project extends Model implements HasLocalisedSlugs
{
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SoftDeletes;

    protected $fillable = [
        'industry_id',
        'status',
        'published_at',
        'sort_order',
        'is_featured',
        'year',
        'instagram_handle',
        'cover_path',
        'banner_path',
        'before_image_path',
        'after_image_path',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'challenge',
        'challenge_points',
        'results_summary',
        'seo_title',
        'seo_description',
        'cover_alt',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublicationStatus::class,
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return ProjectTranslation::class;
    }

    /* ------------------------------------------------------- relationships */

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function images(): HasMany
    {
        return $this
            ->hasMany(ProjectImage::class)
            ->orderBy('sort_order');
    }

    public function sections(): MorphMany
    {
        return $this
            ->morphMany(PageSection::class, 'sectionable')
            ->orderBy('sort_order');
    }

    public function section(SectionType $type): ?PageSection
    {
        return $this->sections->firstWhere('type', $type);
    }

    /* -------------------------------------------------------------- routing */

    /**
     * Bind by the slug of the ACTIVE locale, so /fa/work/{slug} only matches a
     * Persian slug. Prevents an English URL silently resolving under /fa/.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this
            ->published()
            ->whereSlug((string) $value)
            ->withTranslations()
            ->first();
    }

    public function slugForLocale(string $locale): string
    {
        return (string) ($this->getTranslation('slug', $locale)
            ?? $this->getTranslation('slug', config('locales.fallback')));
    }

    public function url(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return route('work.show', [
            'locale' => $locale,
            'project' => $this->slugForLocale($locale),
        ]);
    }

    /* --------------------------------------------------------------- scopes */

    /**
     * Listing query: published, ordered, with everything a card needs.
     */
    public function scopeForListing(Builder $query): Builder
    {
        $locales = self::activeLocales();

        return $query
            ->published()
            ->with([
                'translations' => fn ($q) => $q->whereIn('locale', $locales),
                'industry.translations' => fn ($q) => $q->whereIn('locale', $locales),
            ])
            ->orderBy('sort_order')
            ->orderByDesc('published_at');
    }

    /**
     * Detail query: adds sections, items, gallery and services.
     */
    public function scopeWithFullDetail(Builder $query): Builder
    {
        $locales = self::activeLocales();

        return $query->with([
            'translations' => fn ($q) => $q->whereIn('locale', $locales),
            'industry.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'services.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'images.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'sections' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order'),
            'sections.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'sections.items' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order'),
            'sections.items.translations' => fn ($q) => $q->whereIn('locale', $locales),
        ]);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * The next project in display order, wrapping to the first.
     * Figma 1323:7541 shows a "Next Case Study" link.
     */
    public function nextProject(): ?self
    {
        $next = self::query()
            ->published()
            ->where('sort_order', '>', $this->sort_order)
            ->whereKeyNot($this->getKey())
            ->withTranslations()
            ->orderBy('sort_order')
            ->first();

        return $next ?? self::query()
            ->published()
            ->whereKeyNot($this->getKey())
            ->withTranslations()
            ->orderBy('sort_order')
            ->first();
    }

    /**
     * @return array<int, string>
     */
    private static function activeLocales(): array
    {
        return array_unique([app()->getLocale(), config('locales.fallback')]);
    }
}
