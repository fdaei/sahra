<?php

declare(strict_types=1);

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (post, locale).
 */
final class PostTranslation extends Model
{
    protected $fillable = [
        'locale',
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'content',
        'seo_title',
        'seo_description',
        'cover_alt',
    ];
}
