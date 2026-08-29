<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Cached accessor for the key/value settings store and social links.
 *
 * Settings are edited in Filament (Pages\ManageSettings) and flushed by the
 * Setting model's saved/deleted events, so the cache never goes stale.
 */
final class SiteSettings
{
    private const CACHE_KEY = 'site.settings';

    private const SOCIAL_CACHE_KEY = 'site.social_links';

    private const TTL = 86400; // 24h — invalidated on write anyway

    /**
     * Everything the header, footer and SEO defaults need.
     *
     * @return array<string, mixed>
     */
    public static function forFrontend(string $locale): array
    {
        return [
            'siteName' => self::get('site_name', $locale, 'Sahra'),
            'tagline' => self::get('tagline', $locale, ''),
            'description' => self::get('footer_description', $locale, ''),

            'contact' => [
                'whatsapp' => self::get('contact_whatsapp', $locale, ''),
                'phone' => self::get('contact_phone', $locale, ''),
                'email' => self::get('contact_email', $locale, ''),
                'location' => self::get('contact_location', $locale, ''),
                'workingWith' => self::get('contact_working_with', $locale, ''),
            ],

            'socialLinks' => self::socialLinks(),

            'seo' => [
                'defaultTitle' => self::get('seo_default_title', $locale, 'Sahra'),
                'defaultDescription' => self::get('seo_default_description', $locale, ''),
                'defaultImage' => self::mediaUrl(self::get('seo_default_image', $locale, null)),
                'organizationName' => self::get('seo_organization_name', $locale, 'Sahra'),
            ],
        ];
    }

    /**
     * Read a single translated setting value.
     */
    public static function get(string $key, ?string $locale = null, mixed $default = null): mixed
    {
        $locale ??= app()->getLocale();

        $all = self::all();

        if (! isset($all[$key])) {
            return $default;
        }

        $value = $all[$key];

        // Non-translatable values are stored as {"value": ...}. Unwrap that
        // envelope before treating an array as a locale map.
        if (is_array($value) && array_key_exists('value', $value)) {
            $value = $value['value'];
        }

        // Translatable settings are stored as {"en": "...", "fa": "..."}.
        if (is_array($value)) {
            return $value[$locale]
                ?? $value[config('locales.fallback')]
                ?? $default;
        }

        return $value === null || $value === '' ? $default : $value;
    }

    /**
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            self::TTL,
            fn (): array => Setting::query()
                ->get()
                ->mapWithKeys(fn (Setting $s): array => [$s->key => $s->value])
                ->all(),
        );
    }

    /**
     * Third-party analytics/tracking IDs, entered in Filament and read
     * server-side into the Inertia root view — never routed through JS props
     * since they need to load before Vue hydrates.
     *
     * @return array{gaId: ?string, gtmId: ?string, gscVerification: ?string, hotjarId: ?string}
     */
    public static function integrations(): array
    {
        return [
            'gaId' => self::get('google_analytics_id'),
            'gtmId' => self::get('google_tag_manager_id'),
            'gscVerification' => self::get('google_search_console_verification'),
            'hotjarId' => self::get('hotjar_site_id'),
        ];
    }

    /**
     * @return array<int, array{platform: string, label: string, url: string, icon: string}>
     */
    public static function socialLinks(): array
    {
        return Cache::remember(
            self::SOCIAL_CACHE_KEY,
            self::TTL,
            fn (): array => SocialLink::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (SocialLink $l): array => [
                    'platform' => $l->platform,
                    'label' => $l->label,
                    'url' => $l->url,
                    'icon' => IconUrl::resolve($l->icon) ?? '',
                ])
                ->all(),
        );
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::SOCIAL_CACHE_KEY);
    }

    private static function mediaUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}
