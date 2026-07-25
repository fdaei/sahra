<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (project, locale).
 */
final class ProjectTranslation extends Model
{
    protected $fillable = [
        'locale',
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'challenge',
        'challenge_points',
        'results_summary',
        'seo_title',
        'seo_description',
        'cover_alt',
    ];

    protected function casts(): array
    {
        return [
            'challenge_points' => 'array',
        ];
    }
}
