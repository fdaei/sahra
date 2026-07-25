<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PublicationStatus;
use App\Models\Translations\ServiceTranslation;
use App\Traits\HasTranslations;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A service offering.
 *
 * Figma: Services page 1323:7189 renders these as alternating full-width
 * sections; the Home services cloud 1419:9279 renders the `show_on_home`
 * subset as chips.
 *
 * There is deliberately NO public detail route — the design has no such frame.
 * The slug is an in-page anchor (/services#branding) and a filter key only.
 * Services remain independently manageable: sortable, publishable,
 * translatable, soft-deletable, and attachable to Projects.
 */
final class Service extends Model
{
    use HasFactory;
    use HasTranslations;
    use Publishable;
    use SoftDeletes;

    protected $fillable = [
        'status',
        'published_at',
        'sort_order',
        'show_on_home',
        'icon',
        'image_path',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'title',
        'slug',
        'description',
        'features',
        'image_alt',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublicationStatus::class,
            'published_at' => 'datetime',
            'show_on_home' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return ServiceTranslation::class;
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Published services in display order, translations preloaded.
     */
    public function scopeForDisplay(Builder $query): Builder
    {
        return $query
            ->published()
            ->withTranslations()
            ->orderBy('sort_order');
    }

    public function scopeOnHome(Builder $query): Builder
    {
        return $query->where('show_on_home', true);
    }

    /**
     * In-page anchor target used by the Services page and Home chips.
     */
    public function anchor(?string $locale = null): string
    {
        return (string) $this->getTranslation('slug', $locale);
    }
}
