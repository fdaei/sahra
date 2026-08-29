<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasLocalisedSlugs;
use App\Enums\PublicationStatus;
use App\Models\Translations\PostTranslation;
use App\Traits\HasTranslations;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * A blog article.
 *
 * Figma: listing 1353:7935 (one featured large card + grid),
 *        detail 1352:7391 (meta sidebar, share rail, related articles).
 */
final class Post extends Model implements HasLocalisedSlugs
{
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SoftDeletes;

    protected $fillable = [
        'post_category_id',
        'user_id',
        'status',
        'published_at',
        'is_featured',
        'cover_path',
        'lead_magnet_file_path',
        'lead_magnet_allow_download',
        'lead_magnet_send_email',
        'lead_magnet_image_path',
        'lead_magnet_cta_icon',
        'reading_minutes',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'content',
        'lead_magnet_title',
        'lead_magnet_description',
        'lead_magnet_cta_label',
        'lead_magnet_image_alt',
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
            'lead_magnet_allow_download' => 'boolean',
            'lead_magnet_send_email' => 'boolean',
            'reading_minutes' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return PostTranslation::class;
    }

    /* ------------------------------------------------------- relationships */

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tag');
    }

    public function leadMagnetDeliveries(): HasMany
    {
        return $this->hasMany(LeadMagnetDelivery::class);
    }

    /* -------------------------------------------------------------- routing */

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

    public function url(?string $locale = null, bool $absolute = true): string
    {
        $locale ??= app()->getLocale();

        return route('insights.show', [
            'locale' => $locale,
            'post' => $this->slugForLocale($locale),
        ], absolute: $absolute);
    }

    /* --------------------------------------------------------------- scopes */

    public function scopeForListing(Builder $query): Builder
    {
        $locales = self::activeLocales();

        return $query
            ->published()
            ->with([
                'translations' => fn ($q) => $q->whereIn('locale', $locales),
                'category.translations' => fn ($q) => $q->whereIn('locale', $locales),
            ])
            ->orderByDesc('published_at');
    }

    public function scopeWithFullDetail(Builder $query): Builder
    {
        $locales = self::activeLocales();

        return $query->with([
            'translations' => fn ($q) => $q->whereIn('locale', $locales),
            'category.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'tags.translations' => fn ($q) => $q->whereIn('locale', $locales),
            'author',
        ]);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeInCategory(Builder $query, string $categorySlug): Builder
    {
        $locale = app()->getLocale();

        return $query->whereHas(
            'category.translations',
            fn ($q) => $q->where('locale', $locale)->where('slug', $categorySlug),
        );
    }

    /**
     * Same category first, newest first, excluding self.
     * Figma 1352:7391 shows three related cards.
     */
    public function relatedPosts(int $limit = 3): Collection
    {
        $locales = self::activeLocales();

        $query = self::query()
            ->published()
            ->whereKeyNot($this->getKey())
            ->with([
                'translations' => fn ($q) => $q->whereIn('locale', $locales),
                'category.translations' => fn ($q) => $q->whereIn('locale', $locales),
            ]);

        if ($this->post_category_id !== null) {
            $query->orderByRaw(
                'CASE WHEN post_category_id = ? THEN 0 ELSE 1 END',
                [$this->post_category_id],
            );
        }

        return $query->orderByDesc('published_at')->limit($limit)->get();
    }

    /**
     * Word-count estimate at 200 wpm, minimum one minute.
     * Called on save so the stored value stays in sync with the content.
     */
    public function calculateReadingMinutes(?string $locale = null): int
    {
        $content = (string) $this->getTranslation('content', $locale);
        $words = str_word_count(strip_tags($content));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * @return array<int, string>
     */
    private static function activeLocales(): array
    {
        return array_unique([app()->getLocale(), config('locales.fallback')]);
    }
}
