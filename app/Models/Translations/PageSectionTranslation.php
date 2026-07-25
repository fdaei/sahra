<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (parent, locale) — enforced by a composite unique
 * index in the migration.
 */
final class PageSectionTranslation extends Model
{
    protected $fillable = [
        'locale',
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

}
