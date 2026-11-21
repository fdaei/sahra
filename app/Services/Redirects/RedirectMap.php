<?php

declare(strict_types=1);

namespace App\Services\Redirects;

use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;

/**
 * Cached source_path => [destination, status, id] map of active redirects.
 * Read on every request by App\Http\Middleware\ApplyRedirects; flushed by
 * Redirect on every save/delete.
 */
final class RedirectMap
{
    public const CACHE_KEY = 'redirects.map.v1';

    /** @return array<string, array{0:string, 1:int, 2:int}> */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn (): array => Redirect::query()
            ->active()
            ->get(['id', 'source_path', 'destination_path', 'status_code'])
            ->mapWithKeys(fn (Redirect $r): array => [
                $r->source_path => [$r->destination_path, (int) $r->status_code, (int) $r->id],
            ])
            ->all());
    }

    /** @return array{0:string, 1:int, 2:int}|null */
    public static function find(string $path): ?array
    {
        return self::all()[Redirect::normalize($path)] ?? null;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
