<?php

declare(strict_types=1);

namespace App\Services\Redirects;

use App\Models\NotFoundVisit;
use App\Models\Redirect;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

final class NotFoundMonitor
{
    public function record(Request $request): void
    {
        try {
            if (! SiteSettings::get('seo_404_monitor_enabled', null, false) || ! $request->isMethod('GET') || $request->expectsJson()) {
                return;
            }
            $path = Redirect::normalize($request->getPathInfo());
            $locale = explode('/', $path, 2)[0];
            if (! array_key_exists($locale, config('locales.supported')) || ! str_contains($path, '/')
                || ! mb_check_encoding($path, 'UTF-8') || mb_strlen($path) > 500
                || preg_match('/[\\x00-\\x1f\\x7f]/', $path)
                || preg_match('/\\.(?:css|js|map|png|jpe?g|gif|webp|avif|svg|ico|woff2?|ttf)$/i', $path)) {
                return;
            }
            if (RateLimiter::tooManyAttempts('seo-404-monitor', 120)) {
                return;
            }
            RateLimiter::hit('seo-404-monitor', 60);
            $hash = hash('sha256', $path);
            $now = now();
            $query = NotFoundVisit::query()->where('path_hash', $hash);
            if ($query->update(['hits' => DB::raw('hits + 1'), 'last_seen_at' => $now]) > 0) {
                return;
            }
            if (NotFoundVisit::query()->count() >= 10000) {
                return;
            }
            $inserted = DB::table('not_found_visits')->insertOrIgnore([
                'path_hash' => $hash, 'path' => $path, 'hits' => 1, 'first_seen_at' => $now, 'last_seen_at' => $now,
            ]);
            if ($inserted === 0) {
                NotFoundVisit::query()->where('path_hash', $hash)->update(['hits' => DB::raw('hits + 1'), 'last_seen_at' => $now]);
            }
        } catch (\Throwable $exception) {
            // The reporting feature must not change the original 404 response.
            report($exception);
        }
    }
}
