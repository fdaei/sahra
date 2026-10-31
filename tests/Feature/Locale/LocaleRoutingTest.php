<?php

declare(strict_types=1);

use App\Models\Page;
use App\Support\LocaleAlternates;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

it('redirects a bare path to the default locale', function (): void {
    $this->get('/')->assertStatus(301)->assertRedirect('/en');
});

it('uses English entry URLs even when a previous session selected Persian', function (): void {
    $this->withSession(['locale' => 'fa'])
        ->get('/about')
        ->assertStatus(301)
        ->assertRedirect('/en/about');
});

it('ignores browser language when entering the bare domain', function (string $language): void {
    $this->get('/', ['Accept-Language' => $language])
        ->assertStatus(301)->assertRedirect('/en');
})->with(['fa-IR,fa;q=0.9,en;q=0.8', 'ar-OM,ar;q=0.9', 'en-US,en;q=0.9', '']);

it('ignores saved language on the bare domain and preserves query parameters', function (string $locale): void {
    $this->withSession(['locale' => $locale])->get('/?utm_source=campaign', ['Accept-Language' => 'fa-IR'])
        ->assertStatus(301)->assertRedirect('/en?utm_source=campaign');
})->with(['fa', 'ar']);

it('keeps explicit Persian URLs Persian even with an English session and browser', function (): void {
    Page::factory()->create(['key' => 'home'])->setTranslations(['fa' => ['title' => 'صفحهٔ فارسی']]);
    $this->withSession(['locale' => 'en'])->get('/fa', ['Accept-Language' => 'en-US'])
        ->assertOk()->assertSee('lang="fa"', false)->assertSee('dir="rtl"', false);
});

it('does not fabricate hreflang URLs for unnamed fallback routes', function (): void {
    $request = Request::create('/missing');
    $route = new Route(['GET'], '/missing', fn () => null);
    $route->bind($request);
    $request->setRouteResolver(fn () => $route);
    expect(LocaleAlternates::for($request))->toBe([]);
});

it('serves each supported locale prefix', function (string $locale): void {
    Page::factory()->create(['key' => 'home'])->setTranslations([
        $locale => ['title' => 'Test title'],
    ]);

    $this->get("/{$locale}")->assertOk();
})->with(['en', 'fa', 'ar']);

it('rejects an unsupported locale segment as not-found', function (): void {
    $this->get('/xx')->assertNotFound();
});

it('sets rtl for persian', function (): void {
    Page::factory()->create(['key' => 'home'])->setTranslations([
        'fa' => ['title' => 'تست'],
    ]);

    $this->get('/fa')->assertOk()->assertSee('dir="rtl"', false);
});

it('sets ltr for english', function (): void {
    Page::factory()->create(['key' => 'home'])->setTranslations([
        'en' => ['title' => 'Test'],
    ]);

    $this->get('/en')->assertOk()->assertSee('dir="ltr"', false);
});
