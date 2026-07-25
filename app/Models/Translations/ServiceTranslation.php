<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (service, locale).
 * `features` is the bullet list shown beside each service section.
 */
final class ServiceTranslation extends Model
{
    protected $fillable = [
        'locale',
        'title',
        'slug',
        'description',
        'features',
        'image_alt',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
        ];
    }
}
