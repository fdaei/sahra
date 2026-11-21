<?php

declare(strict_types=1);

namespace App\Models\Translations;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;

/**
 * Per-locale SEO metadata for one media file.
 */
final class MediaTranslation extends Model
{
    protected $fillable = ['locale', 'title', 'alt', 'caption', 'description'];

    protected static function booted(): void
    {
        self::saved(fn () => Media::flushAltMap());
        self::deleted(fn () => Media::flushAltMap());
    }
}
