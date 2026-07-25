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
        ],

    ],

];
