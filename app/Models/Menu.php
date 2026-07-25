<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MenuLocation;
use App\Support\NavigationBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A navigation menu. Figma: header 1419:9339, footer 1419:9317.
 */
final class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    protected function casts(): array
    {
        return ['location' => MenuLocation::class];
    }

    protected static function booted(): void
    {
        static::saved(fn () => NavigationBuilder::flush());
        static::deleted(fn () => NavigationBuilder::flush());
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    /**
     * Top-level items with their children preloaded.
     */
    public function rootItems(): HasMany
    {
        return $this->items()->whereNull('parent_id');
    }
}
