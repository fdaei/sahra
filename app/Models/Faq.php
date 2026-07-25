<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\FaqTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Home FAQ accordion entry. Figma 1419:9272.
 */
final class Faq extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'sort_order',
        'is_active',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['question', 'answer'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return FaqTranslation::class;
    }

    public function scopeForDisplay($query)
    {
        return $query
            ->where('is_active', true)
            ->withTranslations()
            ->orderBy('sort_order');
    }
}
