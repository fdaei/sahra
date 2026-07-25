<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'name' => env('APP_NAME', 'Sahra'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'UTC',

    /*
     | The `locale` here is the Laravel/validation-message locale, distinct
     | from config/locales.php which drives the public-facing en/fa/ar system.
     | Kept in sync with locales.default so validation strings load correctly
     | before SetLocale middleware runs (e.g. during console commands).
     */
    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => array_filter(explode(',', (string) env('APP_PREVIOUS_KEYS', ''))),

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
     | Core framework providers must remain in this list. Package providers are
     | added through Composer discovery, while application providers are merged
     | from bootstrap/providers.php.
     */
    'providers' => ServiceProvider::defaultProviders()->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        // Add custom facade aliases here if needed.
    ])->toArray(),

];
