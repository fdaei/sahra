<?php

declare(strict_types=1);

use App\Models\Page;

it('redirects a bare path to the default locale', function (): void {
    $this->get('/')->assertRedirect('/en');
});

it('redirects a bare path to a previously selected locale via session', function (): void {
    $this->withSession(['locale' => 'fa'])
        ->get('/about')
        ->assertRedirect('/fa/about');
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
