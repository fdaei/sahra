<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\PublicPageCache;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CachePublicPage
{
    private const TTL = 300;

    public function handle(Request $request, Closure $next): Response
    {
        if (! config('cache.public_pages') || config('app.debug') || ! $request->isMethod('GET')
            || $request->getQueryString() !== null || $request->expectsJson() || $request->headers->has('Authorization')) {
            return $next($request);
        }

        $session = $request->session();
        $token = $session->token();
        $publicSessionKeys = ['_token' => true, '_previous' => true, '_flash' => true, 'locale' => true];
        if (! is_string($token) || $token === '' || array_diff_key($session->all(), $publicSessionKeys) !== []
            || $request->user() !== null) {
            return $next($request);
        }

        $cache = PublicPageCache::store();
        $revision = PublicPageCache::revision();
        $key = 'public-pages.html.v2.'.hash('sha256', $request->url());
        $entry = $cache->get($key);
        $field = (string) csrf_field();

        if (is_array($entry) && $entry['revision'] === $revision) {
            return response(implode($field, $entry['parts']), 200, $entry['headers'])
                ->header('X-Sahra-Page-Cache', 'HIT');
        }

        $response = $next($request);
        $body = $response->getContent();
        if ($response->getStatusCode() !== 200 || ! is_string($body)
            || ! str_starts_with((string) $response->headers->get('Content-Type'), 'text/html')
            || $response->headers->getCookies() !== [] || $response->headers->hasCacheControlDirective('no-store')) {
            return $response;
        }

        // Persist the text around each form field. The session creates its own
        // CSRF field when we join these parts on a later request.
        $parts = explode($field, $body);
        if (str_contains(implode('', $parts), $token)) {
            return $response;
        }

        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache');
        $headers = $response->headers->all();
        unset($headers['date'], $headers['content-length']);
        $cache->put($key, ['revision' => $revision, 'parts' => $parts, 'headers' => $headers], self::TTL);
        $response->headers->set('X-Sahra-Page-Cache', 'MISS');

        return $response;
    }
}
