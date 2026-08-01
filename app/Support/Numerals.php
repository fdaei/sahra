<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Renders numbers in the active locale's digit system.
 *
 * Carbon's translatedFormat() localises month and day names but always emits
 * ASCII digits, and CSS cannot help: `font-variant-numeric` selects between
 * lining and oldstyle figures within one script, it does not transliterate
 * between Unicode digit blocks. So any number that reaches an fa/ar page has
 * to be converted here, in PHP, before it is handed to Inertia.
 *
 * Digit sets live in config/locales.php alongside direction and date_format,
 * so adding a locale stays a one-file change. `digits` is null for locales
 * that already use ASCII.
 *
 * Authored content (a KPI value typed into Filament) is NOT converted — the
 * editor writes the digits they want and we render them verbatim. This class
 * is only for values the application itself generates.
 */
final class Numerals
{
    /**
     * Transliterate every ASCII digit in $value into $locale's digit set.
     * Non-digit characters (separators, percent signs, letters) pass through.
     */
    public static function localise(string $value, ?string $locale = null): string
    {
        $digits = self::digitsFor($locale ?? app()->getLocale());

        if ($digits === null) {
            return $value;
        }

        return strtr($value, $digits);
    }

    /**
     * Same, for an integer or float that has already been formatted upstream.
     */
    public static function localiseNumber(int|float $value, ?string $locale = null): string
    {
        return self::localise((string) $value, $locale);
    }

    /**
     * ASCII digit => locale digit map, or null when the locale needs no
     * conversion. Cached per locale because this runs once per rendered date.
     *
     * @return array<string, string>|null
     */
    private static function digitsFor(string $locale): ?array
    {
        static $cache = [];

        if (array_key_exists($locale, $cache)) {
            return $cache[$locale];
        }

        $set = config("locales.supported.{$locale}.digits");

        if (! is_string($set) || $set === '') {
            return $cache[$locale] = null;
        }

        // mb_str_split: each glyph is multi-byte, so a byte-wise split breaks it.
        $glyphs = mb_str_split($set);

        if (count($glyphs) !== 10) {
            return $cache[$locale] = null;
        }

        return $cache[$locale] = array_combine(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $glyphs,
        );
    }
}
