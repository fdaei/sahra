<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\SectionItemTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A repeatable card inside a PageSection — KPI counter, process step,
 * why-us card, goal, strategy pillar, deliverable, or result stat.
 */
final class SectionItem extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'page_section_id',
        'sort_order',
        'is_visible',
        'icon',
        'image_path',
    ];

    /** @var array<int, string> */
    protected array $translatable = [
        'value',
        'label',
        'suffix',
        'title',
        'description',
        'badge',
        'features',
        'footer',
        'image_alt',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return SectionItemTranslation::class;
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
