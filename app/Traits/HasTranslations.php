<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * Translation-table support.
 *
 * Every translatable entity has a sibling `{entity}_translations` table with a
 * (entity_id, locale) unique key. This trait wires that up and exposes the
 * translated columns as if they were native attributes:
 *
 *     $post->title            // active locale, falls back to config default
 *     $post->translate('fa')->title
 *     $post->getTranslation('title', 'ar')
 *     $post->setTranslations(['en' => [...], 'fa' => [...]])
 *
 * The consuming model declares:
 *     protected array $translatable = ['title', 'slug', ...];
 *     public function translationModel(): string { return PostTranslation::class; }
 *
 * Always eager-load `translations` (or `translation` for the active locale)
 * when rendering lists — see each model's public scopes, which do this for you.
 */
trait HasTranslations
{
    /**
     * All translations for this record.
     */
    public function translations(): HasMany
    {
        return $this->hasMany($this->translationModel(), $this->translationForeignKey());
    }

    /**
     * Single translation constrained to the active locale.
     * Lets controllers eager-load exactly one row per record instead of three.
     */
    public function translation(): HasOne
    {
        return $this
            ->hasOne($this->translationModel(), $this->translationForeignKey())
            ->where('locale', app()->getLocale());
    }

    /**
     * The translation row for a specific locale, with fallback.
     */
    public function translate(?string $locale = null, bool $withFallback = true): ?Model
    {
        $locale ??= app()->getLocale();

        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        $match = $translations->firstWhere('locale', $locale);

        if ($match !== null) {
            return $match;
        }

        if (! $withFallback) {
            return null;
        }

        $fallback = config('locales.fallback');

        return $translations->firstWhere('locale', $fallback) ?? $translations->first();
    }

    /**
     * Read one translated column.
     */
    public function getTranslation(string $attribute, ?string $locale = null, bool $withFallback = true): mixed
    {
        $translation = $this->translate($locale, $withFallback);

        return $translation?->getAttribute($attribute);
    }

    /**
     * Write translations for one or more locales, then persist.
     *
     * @param  array<string, array<string, mixed>>  $data  locale => attributes
     */
    public function setTranslations(array $data): static
    {
        DB::transaction(function () use ($data): void {
            foreach ($data as $locale => $attributes) {
                if (! array_key_exists($locale, config('locales.supported'))) {
                    continue;
                }

                $attributes = array_intersect_key(
                    $attributes,
                    array_flip($this->translatableAttributes()),
                );

                if ($attributes === []) {
                    continue;
                }

                $this->translations()->updateOrCreate(
                    ['locale' => $locale],
                    $attributes,
                );
            }
        });

        return $this->load('translations');
    }

    /**
     * Fall through to the translation row for declared translatable columns.
     */
    public function getAttribute($key)
    {
        if (in_array($key, $this->translatableAttributes(), true)
            && ! array_key_exists($key, $this->attributes)
        ) {
            return $this->getTranslation($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Constrain a query to records having a translation in the given locale.
     */
    public function scopeHasTranslation($query, ?string $locale = null)
    {
        $locale ??= app()->getLocale();

        return $query->whereHas('translations', fn ($q) => $q->where('locale', $locale));
    }

    /**
     * Resolve by translated slug within a locale.
     */
    public function scopeWhereSlug($query, string $slug, ?string $locale = null)
    {
        $locale ??= app()->getLocale();

        return $query->whereHas(
            'translations',
            fn ($q) => $q->where('locale', $locale)->where('slug', $slug),
        );
    }

    /**
     * Eager-load translations for list rendering. Prevents N+1.
     */
    public function scopeWithTranslations($query, ?string $locale = null)
    {
        $locale ??= app()->getLocale();
        $fallback = config('locales.fallback');

        return $query->with([
            'translations' => fn ($q) => $q->whereIn('locale', array_unique([$locale, $fallback])),
        ]);
    }

    /**
     * @return array<int, string>
     */
    public function translatableAttributes(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * FQCN of the translation model. Overridden per entity.
     */
    abstract public function translationModel(): string;

    protected function translationForeignKey(): string
    {
        return $this->getForeignKey(); // e.g. post_id
    }
}
