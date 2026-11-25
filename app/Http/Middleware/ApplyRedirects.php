<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Redirect;
use App\Services\Redirects\RedirectMap;
use App\Services\Redirects\RedirectSafety;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves editor-managed redirects (Filament → Redirects, plus the automatic
 * ones created on slug change). Global, so it runs before routing: an old
 * slug would otherwise 404 inside route-model binding first.
 */
final class ApplyRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return $next($request);
        }

        $path = $request->path();
        if ($path === 'up' || str_starts_with($path, 'admin') || str_starts_with($path, 'livewire') || str_starts_with($path, 'build/')) {
            return $next($request);
        }

        $match = RedirectMap::find($path);
        if ($match === null) {
            return $next($request);
        }

        [$destination, $status, $id] = $match;

        if (in_array($status, Redirect::GONE, true)) {
            Redirect::query()->find($id)?->recordHit();

            return response('', $status);
        }

        if (! array_key_exists($status, Redirect::STATUSES)
            || ! RedirectSafety::validDestination($destination, allowStoredRoot: true)
            || RedirectSafety::createsAnyLoop($path, $destination)) {
            return $next($request); // Ignore invalid destinations and redirect loops.
        }

        Redirect::query()->find($id)?->recordHit();

        $target = preg_match('#^https?://#i', $destination)
            ? $destination
            : url('/'.implode('/', array_map('rawurlencode', explode('/', $destination))));

        if ($request->getQueryString() !== null && ! str_contains($target, '?')) {
            $target .= '?'.$request->getQueryString();
        }

        return redirect()->away($target, $status);
    }
}
