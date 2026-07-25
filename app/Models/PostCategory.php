<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\PostCategoryTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Blog category. Doubles as the listing filter chips (Figma 1363:7500).
 */
final class PostCategory extends Model
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
        return PostCategoryTranslation::class;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
