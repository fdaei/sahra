<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\SiteSettings;
use Illuminate\Database\Eloquent\Model;

/**
 * Key/value site setting.
 *
 * Translatable values are stored as {"en":…,"fa":…,"ar":…} in the JSON column.
 * This is the one documented exception to the translation-table rule — see the
 * migration header for the reasoning.
 *
 * Cache is flushed on write so App\Support\SiteSettings never serves stale data.
 */
final class Setting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
        'is_translatable',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_translatable' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::flush());
        static::deleted(fn () => SiteSettings::flush());
    }
}
