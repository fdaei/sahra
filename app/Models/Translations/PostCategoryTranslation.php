<?php

declare(strict_types=1);

namespace App\Models\Translations;

use App\Support\NavigationBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * Translation row. One per (parent, locale) — enforced by a composite unique
 * index in the migration.
 */
final class PostCategoryTranslation extends Model
{
    protected $fillable = [
        'locale',
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        // Category names/slugs feed generated header dropdowns.
        self::saved(fn () => NavigationBuilder::flush());
        self::deleted(fn () => NavigationBuilder::flush());
    }
}
