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
 *   /            -> /en           (or session / Accept-Language preference)
 *   /about       -> /en/about
 *   /work/x      -> /fa/work/x    (if the visitor's stored locale is fa)
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

        $locale = $this->preferred($request, $supported);

        $path = trim($request->path(), '/');
        $target = $path === '' ? "/{$locale}" : "/{$locale}/{$path}";

        if ($query = $request->getQueryString()) {
            $target .= "?{$query}";
        }

        // 302 rather than 301: a visitor's language preference can legitimately
        // change, and we do not want that cached permanently by the browser.
        return redirect($target, 302);
    }

    /**
     * @param  array<int, string>  $supported
     */
    private function preferred(Request $request, array $supported): string
    {
        $session = $request->session()->get('locale');

        if (is_string($session) && in_array($session, $supported, true)) {
            return $session;
        }

        $header = $request->getPreferredLanguage($supported);

        if (is_string($header) && in_array($header, $supported, true)) {
            return $header;
        }

        return config('locales.default');
    }
}
