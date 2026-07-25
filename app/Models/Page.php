<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Models\Translations\PageTranslation;
use App\Traits\HasTranslations;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * An editable page. Resolved by `key`, never by id or slug, so renaming a page
 * in admin cannot break a route.
 *
 * Keys in use (docs/TRACEABILITY.md):
 *   home · about · contact · work · insights · services · privacy-policy · terms
 *
 * @property string $key
 * @property PublicationStatus $status
 */
final class Page extends Model
{
    use HasFactory;
    use HasTranslations;
    use Publishable;

    protected $fillable = [
        'key',
        'status',
        'published_at',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'title',
        'subtitle',
        'description',
        'content',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublicationStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function translationModel(): string
    {
        return PageTranslation::class;
    }

    /**
     * Ordered, visible content blocks.
     */
    public function sections(): MorphMany
    {
        return $this
            ->morphMany(PageSection::class, 'sectionable')
            ->orderBy('sort_order');
    }

    /**
     * Fetch one section by type — controllers use this to pull, say, the hero
     * without loading every block.
     */
    public function section(SectionType $type): ?PageSection
    {
        return $this->sections
            ->firstWhere('type', $type);
    }

    /**
     * Eager-load everything a page render needs, in one pass.
     */
    public function scopeWithContent($query)
    {
        $locale = app()->getLocale();
        $fallback = config('locales.fallback');
        $locales = array_unique([$locale, $fallback]);

        return $query
            ->with([
                'translations' => fn ($q) => $q->whereIn('locale', $locales),
                'sections' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order'),
                'sections.translations' => fn ($q) => $q->whereIn('locale', $locales),
                'sections.items' => fn ($q) => $q->where('is_visible', true)->orderBy('sort_order'),
                'sections.items.translations' => fn ($q) => $q->whereIn('locale', $locales),
            ]);
    }

    public function scopeKey($query, string $key)
    {
        return $query->where('key', $key);
    }
}
