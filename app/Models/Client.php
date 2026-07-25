<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\ClientTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Trust-proof logo. Figma 1419:9205 strip (animation A2).
 */
final class Client extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'logo_path',
        'website_url',
        'sort_order',
        'is_active',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['name', 'logo_alt'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return ClientTranslation::class;
    }

    public function scopeForDisplay($query)
    {
        return $query
            ->where('is_active', true)
            ->withTranslations()
            ->orderBy('sort_order');
    }
}
