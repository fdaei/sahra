<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\TestimonialTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Customer review. Figma 1419:9243 marquee, card 1419:9251.
 */
final class Testimonial extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'avatar_path',
        'sort_order',
        'is_active',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['author_name', 'author_role', 'quote', 'avatar_alt'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return TestimonialTranslation::class;
    }

    public function scopeForDisplay($query)
    {
        return $query
            ->where('is_active', true)
            ->withTranslations()
            ->orderBy('sort_order');
    }
}
