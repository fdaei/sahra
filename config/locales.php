<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Locale configuration
|--------------------------------------------------------------------------
|
| Single source of truth for supported locales. Consumed by:
|   - App\Http\Middleware\SetLocale         (request handling)
|   - App\Http\Middleware\HandleInertiaRequests (shared props)
|   - routes/web.php                        (route prefix constraint)
|   - App\Traits\HasTranslations             (translatable columns)
|   - Filament translatable field tabs
|
| Font families map to the Figma type systems:
|   en -> "EN-Desktop/*" tokens  -> Poppins
|   fa -> "AR-Desktop/*" tokens  -> Doran FaNum (fallback Vazirmatn)
|   ar -> "AR-Desktop/*" tokens  -> Doran FaNum (fallback Vazirmatn)
|
*/

return [

    'default' => env('APP_LOCALE', 'en'),

    'fallback' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
     | Ordered map. Key = URL segment + DB translation key.
     | Order controls the language-switcher rendering order.
     */
    'supported' => [

        'en' => [
            'name'        => 'English',
            'native'      => 'English',
            'direction'   => 'ltr',
            'font'        => 'sans',
            'html_lang'   => 'en',
            'locale'      => 'en_US',
            'flag'        => 'GB',
            'date_format' => 'M d, Y',
            // Western Arabic (ASCII) digits — no transliteration needed.
            'digits'      => null,
        ],

        'fa' => [
            'name'        => 'Persian',
            'native'      => 'فارسی',
            'direction'   => 'rtl',
            'font'        => 'arabic',
            'html_lang'   => 'fa-IR',
            'locale'      => 'fa_IR',
            'flag'        => 'IR',
            'date_format' => 'Y/m/d',
            /*
             | Extended Arabic-Indic (U+06F0–U+06F9) — the Persian set. Note
             | this is a DIFFERENT Unicode block from Arabic's (U+0660–U+0669);
             | the two look similar for some digits but must not be swapped.
             */
            'digits'      => '۰۱۲۳۴۵۶۷۸۹',
        ],

        'ar' => [
            'name'        => 'Arabic',
            'native'      => 'العربية',
            'direction'   => 'rtl',
            'font'        => 'arabic',
            'html_lang'   => 'ar',
            'locale'      => 'ar_OM',
            'flag'        => 'OM',
            'date_format' => 'Y/m/d',
            // Arabic-Indic (U+0660–U+0669) — not the Persian set above.
            'digits'      => '٠١٢٣٤٥٦٧٨٩',
        ],

    ],

];
