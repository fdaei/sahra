<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Redirects non-prefixed URLs to their locale-prefixed equivalent.
 *
 *   /            -> /en           (the configured default, always English here)
 *   /about       -> /en/about
 * Browser language and a previously selected locale do not change entry URLs.
 *
 * Applied only to the bare-path catch-all group in routes/web.php so it never
 * interferes with already-prefixed traffic, the Filament panel, or storage.
 * Reaching this middleware at all means every real route in the {locale}
 * group already failed to match, so an already-prefixed path here
 * (/en/nonexistent) is a genuine 404, not something to redirect.
 */
final class RedirectToLocalisedRoute
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('locales.supported'));

        $first = $request->segment(1);

        if (is_string($first) && in_array($first, $supported, true)) {
            /*
             | Genuine 404 on an already-localised path. SetLocale never ran —
             | the {locale} group failed to match — so apply the locale here or
             | the Inertia error page renders in the default language and LTR
             | on an /ar or /fa URL, losing direction and chrome.
             */
            SetLocale::apply($request, $first);

            throw new NotFoundHttpException;
        }

        $locale = config('locales.default');

        $path = trim($request->path(), '/');

        // Only legacy public paths are redirected. An arbitrary unknown path
        // must remain a real 404; redirecting every typo to /en/<typo> creates
        // crawlable soft-404 URLs.
        $legacy = ['about', 'work', 'services', 'insights', 'contact', 'privacy-policy', 'terms'];
        if ($path !== '' && ! in_array($path, $legacy, true)) {
            throw new NotFoundHttpException;
        }

        $target = $path === '' ? "/{$locale}" : "/{$locale}/{$path}";

        if ($query = $request->getQueryString()) {
            $target .= "?{$query}";
        }

        // One stable public URL, independent of browser language or cookies.
        return redirect($target, 301);
    }
}
