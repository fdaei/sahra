<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SectionType;
use App\Models\Translations\PageSectionTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * A content block belonging to a Page or a Project.
 *
 * `type` (SectionType) selects the Vue component. Sections whose type
 * `hasItems()` carry repeatable SectionItem children.
 *
 * @property SectionType $type
 */
final class PageSection extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'sectionable_type',
        'sectionable_id',
        'type',
        'sort_order',
        'is_visible',
        'image_path',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'eyebrow',
        'title',
        'subtitle',
        'description',
        'content',
        'primary_cta_label',
        'primary_cta_url',
        'secondary_cta_label',
        'secondary_cta_url',
        'image_alt',
    ];

    protected function casts(): array
    {
        return [
            'type' => SectionType::class,
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return PageSectionTranslation::class;
    }

    public function sectionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function items(): HasMany
    {
        return $this
            ->hasMany(SectionItem::class)
            ->orderBy('sort_order');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOfType($query, SectionType $type)
    {
        return $query->where('type', $type);
    }
}
