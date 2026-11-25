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
    private const REGEX_CACHE_KEY = 'redirects.regex.v1';

    /** @return array<string, array{0:string, 1:int, 2:int}> */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn (): array => Redirect::query()
            ->active()
            ->where('match_type', 'exact')
            ->get(['id', 'source_path', 'destination_path', 'status_code'])
            ->mapWithKeys(fn (Redirect $r): array => [
                $r->source_path => [(string) $r->destination_path, (int) $r->status_code, (int) $r->id],
            ])
            ->all());
    }

    /** @return array{0:string, 1:int, 2:int}|null */
    public static function find(string $path): ?array
    {
        $path = Redirect::normalize($path);
        if (isset(self::all()[$path])) {
            return self::all()[$path];
        }
        $rules = Cache::rememberForever(self::REGEX_CACHE_KEY, fn () => Redirect::query()->active()->where('match_type', 'regex')->orderBy('id')->get(['id', 'source_path', 'destination_path', 'status_code']));
        foreach ($rules as $rule) {
            $pattern = RegexRedirect::pattern($rule->source_path);
            if ($pattern !== null && @preg_match($pattern, $path) === 1) {
                $destination = $rule->destination_path === null ? '' : @preg_replace($pattern, $rule->destination_path, $path, 1);
                if (is_string($destination)) {
                    return [$destination, (int) $rule->status_code, (int) $rule->id];
                }
            }
        }

        return null;
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::REGEX_CACHE_KEY);
    }
}
