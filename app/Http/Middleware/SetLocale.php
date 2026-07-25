<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the active locale from the {locale} route segment and configures
 * the application, Carbon, and URL generation accordingly.
 *
 * Routes are always locale-prefixed (/en/..., /fa/..., /ar/...). A request to
 * a bare path is redirected by RedirectToLocalisedRoute, so by the time this
 * middleware runs the segment is guaranteed present and valid — but we still
 * fall back defensively rather than throwing.
 */
final class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolve($request);

        App::setLocale($locale);

        $config = config("locales.supported.{$locale}");

        // Carbon drives all human-readable dates (post published_at, etc).
        Carbon::setLocale($locale);

        // Every route() and url() call inherits the active locale, so links
        // generated in controllers and Ziggy stay inside the current language.
        URL::defaults(['locale' => $locale]);

        // Consumed by the Blade root view for <html lang dir> and font class.
        $request->attributes->set('locale_direction', $config['direction']);
        $request->attributes->set('locale_font', $config['font']);
        $request->attributes->set('locale_html_lang', $config['html_lang']);

        $response = $next($request);

        // Helps CDNs and browsers cache per-language variants correctly.
        $response->headers->set('Content-Language', $config['html_lang']);

        return $response;
    }

    /**
     * Priority: URL segment > session > Accept-Language > configured default.
     */
    private function resolve(Request $request): string
    {
        $supported = array_keys(config('locales.supported'));

        $fromRoute = $request->route('locale');

        if (is_string($fromRoute) && in_array($fromRoute, $supported, true)) {
            $request->session()->put('locale', $fromRoute);

            return $fromRoute;
        }

        $fromSession = $request->session()->get('locale');

        if (is_string($fromSession) && in_array($fromSession, $supported, true)) {
            return $fromSession;
        }

        $fromHeader = $request->getPreferredLanguage($supported);

        if (is_string($fromHeader) && in_array($fromHeader, $supported, true)) {
            return $fromHeader;
        }

        return config('locales.default');
    }
}
