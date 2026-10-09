<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\CanonicalUrl;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CanonicalRedirect
{
    public function handle(Request $request, Closure $next): Response
    {
        $origin = config('seo.canonical_origin');
        $path = $request->getPathInfo();

        $target = $origin ? parse_url(rtrim($origin, '/')) : null;
        $scheme = strtolower((string) ($request->header('X-Forwarded-Proto') ?: $request->getScheme()));
        $host = strtolower($request->getHost());
        $targetScheme = strtolower((string) ($target['scheme'] ?? $scheme));
        $targetHost = strtolower((string) ($target['host'] ?? $host));

        if ($origin && ($scheme !== $targetScheme || $host !== $targetHost || ($path !== '/' && str_ends_with($path, '/')))) {
            $target = CanonicalUrl::for($path);
            if ($query = $request->getQueryString()) {
                $target .= '?'.$query;
            }

            return redirect()->away($target, $request->isMethod('GET') || $request->isMethod('HEAD') ? 301 : 308);
        }

        return $next($request);
    }
}
