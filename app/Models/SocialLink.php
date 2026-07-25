<?php

declare(strict_types=1);

namespace App\Models;

use App\Support\SiteSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Social profile link. Figma: footer 1419:9317, contact 1363:8934.
 * Not translatable — platform names and URLs are locale-independent.
 */
final class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'label',
        'url',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => SiteSettings::flush());
        static::deleted(fn () => SiteSettings::flush());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
