<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\IndustryTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Project industry tag. Figma: 1362:7211 card tag, 1323:7576 meta row.
 */
final class Industry extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['sort_order'];

    /** @var array<int, string> */
    protected array $translatable = ['name', 'slug'];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function translationModel(): string
    {
        return IndustryTranslation::class;
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
