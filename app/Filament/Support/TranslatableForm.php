<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Builds the per-locale tab group used by every translatable Filament resource,
 * and handles reading/writing the translation rows.
 *
 * Usage in a resource:
 *
 *     TranslatableForm::tabs(fn (string $locale) => [
 *         TextInput::make("translations.{$locale}.title")->required(),
 *         TextInput::make("translations.{$locale}.slug"),
 *     ])
 *
 * and in the Create/Edit pages:
 *
 *     protected function mutateFormDataBeforeCreate(array $data): array
 *     {
 *         return TranslatableForm::extract($data, $this->translations);
 *     }
 *
 * Fields are named `translations.{locale}.{attribute}` so Filament nests them
 * automatically; extract() pulls that sub-array out before the parent model is
 * saved, and persist() writes it through HasTranslations::setTranslations().
 */
final class TranslatableForm
{
    /**
     * One tab per supported locale, each containing the fields the callback
     * produces for that locale.
     *
     * @param  callable(string): array<int, Component>  $fields
     */
    public static function tabs(callable $fields, ?string $label = null): Tabs
    {
        $locales = config('locales.supported');

        return Tabs::make($label ?? 'Translations')
            ->columnSpanFull()
            ->tabs(
                collect($locales)
                    ->map(fn (array $config, string $locale): Tabs\Tab => Tabs\Tab::make($config['native'])
                        ->badge($locale === config('locales.fallback') ? 'default' : null)
                        ->schema($fields($locale))
                        // RTL locales get RTL inputs so editors see the real
                        // reading order while typing.
                        ->extraAttributes([
                            'dir' => $config['direction'],
                            'lang' => $config['html_lang'],
                        ]))
                    ->values()
                    ->all(),
            );
    }

    /**
     * Split the nested `translations` key off the submitted data.
     *
     * @param  array<string, mixed>  $data
     * @return array{0: array<string, mixed>, 1: array<string, array<string, mixed>>}
     */
    public static function split(array $data): array
    {
        $translations = $data['translations'] ?? [];
        unset($data['translations']);

        return [$data, $translations];
    }

    /**
     * Write translations onto a saved model.
     *
     * @param  array<string, array<string, mixed>>  $translations
     */
    public static function persist(Model $model, array $translations): void
    {
        if ($translations === [] || ! method_exists($model, 'setTranslations')) {
            return;
        }

        $model->setTranslations($translations);
    }

    /**
     * Hydrate the form with existing translation rows.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function hydrate(Model $model, array $data): array
    {
        if (! method_exists($model, 'translations')) {
            return $data;
        }

        $attributes = method_exists($model, 'translatableAttributes')
            ? $model->translatableAttributes()
            : [];

        $data['translations'] = $model->translations
            ->mapWithKeys(fn (Model $translation): array => [
                $translation->locale => collect($attributes)
                    ->mapWithKeys(fn (string $attribute): array => [
                        $attribute => $translation->getAttribute($attribute),
                    ])
                    ->all(),
            ])
            ->all();

        return $data;
    }

    /**
     * Auto-slug helper: derives a URL-safe slug from a title field in the same
     * locale tab. Persian and Arabic titles produce transliteration-free slugs,
     * so editors can override — the field stays editable.
     */
    public static function slugify(?string $value, string $locale): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        // Str::slug strips non-Latin characters entirely, which would empty an
        // Arabic or Persian title. For RTL locales keep the script and only
        // normalise whitespace and separators.
        $direction = config("locales.supported.{$locale}.direction");

        if ($direction === 'rtl') {
            return trim(preg_replace('/[\s_]+/u', '-', trim($value)) ?? '', '-');
        }

        return Str::slug($value);
    }
}
