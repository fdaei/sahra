<?php

declare(strict_types=1);

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminLocaleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\LeadMagnetDownloadController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
|
| Every public route is locale-prefixed. Route names are locale-agnostic
| ("home", "work.show") — the {locale} parameter is supplied automatically by
| URL::defaults() in App\Http\Middleware\SetLocale, so route('work.show', $p)
| stays inside the visitor's current language without extra arguments.
|
| Figma traceability lives in docs/TRACEABILITY.md.
|
*/

$localePattern = implode('|', array_keys(config('locales.supported')));

Route::get('admin/language/{locale}', AdminLocaleController::class)
    ->middleware('auth')
    ->whereIn('locale', ['en', 'fa'])
    ->name('admin.locale');

// SEO endpoints — not locale-prefixed.
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('sitemap-{locale}.xml', [SitemapController::class, 'locale'])
    ->where('locale', $localePattern)
    ->name('sitemap.locale');

Route::prefix('{locale}')
    ->where(['locale' => $localePattern])
    ->middleware('locale')
    ->group(function (): void {

        // 1 — Home                       Figma 1419:9192 / 1419:9191
        Route::get('/', HomeController::class)->name('home');

        /*
         | 2 — Projects listing           Figma 1362:7198 / 1498:10840
         |
         | Live height measures 4654px — 2px from 541:1558 (4656) and 14px from
         | the cited 1362:7198 (4640), so this page too was likely built against
         | the older LTR frame. Not conclusive at 2px; see report.md finding 11.
         */
        Route::get('work', [ProjectController::class, 'index'])->name('work.index');

        // 3 — Single project             Figma 1323:7541 / 1555:10866
        Route::get('work/{project}', [ProjectController::class, 'show'])->name('work.show');

        // 4 — Services                   Figma 1323:7189 / 1626:12562
        // Single page, four sections. No detail routes — see FIGMA-AUDIT §4.
        Route::get('services', ServiceController::class)->name('services');

        // 5 — About                      Figma 908:1576 / 1557:12225
        Route::get('about', AboutController::class)->name('about');

        /*
         | 6 — Blog listing               Figma 569:1175 / 1530:10875
         |                                (ar frame: 1353:7935)
         |
         | Corrected 2026-08-08 (AUDIT/figma-final/report.md, findings 4 + 11).
         | This previously cited 1353:7935, which instantiates Header variant
         | 1305:5253 "Property 1=AR" — the Arabic frame. Playwright measured
         | the live page at exactly 4556px, matching 569:1175 (the English
         | frame, Header 176:199) to the pixel and missing 1353:7935 by 63px.
         | The page was built against the LTR frame; the old comment was wrong.
         */
        Route::get('insights', [PostController::class, 'index'])->name('insights.index');

        Route::post('insights/{post}/lead-magnet', [LeadMagnetDownloadController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('insights.lead-magnet.store');
        Route::get('insights/{post}/lead-magnet/download', [LeadMagnetDownloadController::class, 'download'])
            ->name('insights.lead-magnet.download');

        // 7 — Single blog                Figma 1352:7391 / 1543:11175
        Route::get('insights/{post}', [PostController::class, 'show'])->name('insights.show');

        /*
         | 8 — Contact                    Figma 1363:8934 / 1494:9544
         |
         | UNRESOLVED (AUDIT/figma-final/report.md, finding 5): 1363:8934
         | carries Header variant 1305:5253 "Property 1=AR" AND Footer
         | 1390:9179 "Property 1=rtl", so it is the Arabic frame. The English
         | one is 447:790. Same caveat as the blog listing above.
         */
        Route::get('contact', [ContactController::class, 'create'])->name('contact');
        Route::post('contact', [ContactController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('contact.store');

        // Lead magnet / newsletter       Figma 1419:9322, 93:55
        Route::post('newsletter', NewsletterController::class)
            ->middleware('throttle:6,1')
            ->name('newsletter.store');

        // 9/10 — Legal                   Figma 1031:2101, 1309:4891
        Route::get('privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
        Route::get('terms', [LegalController::class, 'terms'])->name('legal.terms');
    });

/*
| Bare-path fallback: /about -> /en/about, / -> /en
| Registered last so it never shadows a real localised route.
*/
Route::middleware('locale.redirect')->group(function (): void {
    Route::get('/', fn () => null);
    Route::get('/{any}', fn () => null)->where('any', '.*');
});
