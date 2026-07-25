<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\MenuItemTranslation;
use App\Support\NavigationBuilder;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

/**
 * A navigation link.
 *
 * Points at either a named route (locale-aware, survives slug changes) or a
 * raw URL. Footer column headings are parents with `url` and `route_name`
 * both null — they render as text, not links.
 */
final class MenuItem extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'route_name',
        'route_params',
        'url',
        'target',
        'is_cta',
        'sort_order',
        'is_active',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['label'];

    protected function casts(): array
    {
        return [
            'route_params' => 'array',
            'is_cta' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => NavigationBuilder::flush());
        static::deleted(fn () => NavigationBuilder::flush());
    }

    public function translationModel(): string
    {
        return MenuItemTranslation::class;
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Resolve to a concrete URL for the given locale.
     * Returns '' for heading-only items so the frontend renders plain text.
     */
    public function resolveUrl(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        if ($this->route_name !== null && Route::has($this->route_name)) {
            return route(
                $this->route_name,
                array_merge(['locale' => $locale], $this->route_params ?? []),
            );
        }

        return (string) $this->url;
    }
}
