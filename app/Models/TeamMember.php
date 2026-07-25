<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\TeamMemberTranslation;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * About-page team grid. Figma 908:1576, card 992:2644.
 */
final class TeamMember extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'photo_path',
        'sort_order',
        'is_active',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['name', 'role', 'photo_alt'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function translationModel(): string
    {
        return TeamMemberTranslation::class;
    }

    public function scopeForDisplay($query)
    {
        return $query
            ->where('is_active', true)
            ->withTranslations()
            ->orderBy('sort_order');
    }
}
