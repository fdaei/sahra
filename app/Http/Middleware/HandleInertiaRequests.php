<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\LocaleAlternates;
use App\Support\NavigationBuilder;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Inertia\Middleware;

/**
 * Shares the props every page needs: active locale + direction, the header and
 * footer menus, site settings, social links, and hreflang alternates.
 *
 * Menus and settings are resolved through cached repositories (see
 * App\Support\SiteSettings and App\Support\NavigationBuilder) so this does not
 * add a query per request once warm.
 */
final class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = app()->getLocale();
        $config = config("locales.supported.{$locale}");

        return array_merge(parent::share($request), [

            'locale' => [
                'current'   => $locale,
                'direction' => $config['direction'],
                'font'      => $config['font'],
                'htmlLang'  => $config['html_lang'],
                'supported' => collect(config('locales.supported'))
                    ->map(fn (array $c, string $code): array => [
                        'code'      => $code,
                        'name'      => $c['name'],
                        'native'    => $c['native'],
                        'direction' => $c['direction'],
                    ])
                    ->values()
                    ->all(),
            ],

            // Same page in the other two languages — powers both the language
            // switcher and the <link rel="alternate" hreflang> tags.
            'alternates' => fn (): array => LocaleAlternates::for($request),

            'navigation' => fn (): array => [
                'header' => NavigationBuilder::header($locale),
                'footer' => NavigationBuilder::footer($locale),
            ],

            'settings' => fn (): array => SiteSettings::forFrontend($locale),

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],

            'auth' => [
                'user' => $request->user()
                    ? [
                        'id'    => $request->user()->id,
                        'name'  => $request->user()->name,
                        'email' => $request->user()->email,
                    ]
                    : null,
            ],

            'ziggy' => fn (): array => [
                ...(new \Tighten\Ziggy\Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ]);
    }
}
