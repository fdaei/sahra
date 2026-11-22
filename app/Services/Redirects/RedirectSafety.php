<?php

declare(strict_types=1);

namespace App\Services\Redirects;

use App\Models\Redirect;

final class RedirectSafety
{
    public static function validDestination(string $destination, bool $allowStoredRoot = false): bool
    {
        $destination = trim($destination);
        if ($destination === '') {
            return $allowStoredRoot;
        }
        if (preg_match('/[\x00-\x1f\x7f]/', $destination)) {
            return false;
        }
        if (preg_match('~^https?://~i', $destination)) {
            $parts = parse_url($destination);
            return filter_var($destination, FILTER_VALIDATE_URL) !== false && is_array($parts)
                && ! isset($parts['user']) && ! isset($parts['pass']);
        }
        if (str_starts_with($destination, '//') || preg_match('~^[a-z][a-z0-9+.-]*:~i', $destination)) {
            return false;
        }
        return ! str_contains($destination, '?') && ! str_contains($destination, '#');
    }

    /** A null result is an external URL, which cannot create an internal loop. */
    public static function localPath(string $destination): ?string
    {
        if (! preg_match('~^https?://~i', $destination)) {
            return Redirect::normalize($destination);
        }
        $host = strtolower((string) parse_url($destination, PHP_URL_HOST));
        $localHosts = array_filter([
            strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST)),
            strtolower((string) parse_url((string) config('seo.canonical_origin'), PHP_URL_HOST)),
            strtolower((string) request()->getHost()),
        ]);
        return in_array($host, $localHosts, true) ? Redirect::normalize($destination) : null;
    }

    /** @param array<string, array{0:string, 1:int, 2:int}> $redirects */
    public static function createsLoop(string $source, string $destination, array $redirects): bool
    {
        $source = Redirect::normalize($source);
        $next = self::localPath($destination);
        $seen = [$source => true];
        while ($next !== null) {
            if (isset($seen[$next])) {
                return true;
            }
            $seen[$next] = true;
            if (! isset($redirects[$next])) {
                return false;
            }
            $next = self::localPath($redirects[$next][0]);
        }
        return false;
    }
}
