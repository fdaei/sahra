<?php

declare(strict_types=1);

use App\Models\Page;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    config([
        'cache.public_pages' => true,
        'cache.public_page_store' => 'array',
        'app.debug' => false,
        'seo.canonical_origin' => null,
    ]);
});

it('rebuilds form tokens for each session and bypasses the cache for feedback', function (): void {
    $page = Page::factory()->create(['key' => 'contact']);
    $page->setTranslations(['en' => ['title' => 'Contact Sahra']]);

    $this->withSession(['_token' => 'first-session-token'])
        ->get('/en/contact')->assertOk()->assertHeader('X-Sahra-Page-Cache', 'MISS')
        ->assertSee('name="_token" value="first-session-token"', false);

    $this->withSession(['_token' => 'second-session-token'])
        ->get('/en/contact')->assertOk()->assertHeader('X-Sahra-Page-Cache', 'HIT')
        ->assertHeader('Cache-Control', 'no-cache, private')
        ->assertSee('name="_token" value="second-session-token"', false)
        ->assertDontSee('first-session-token', false);

    $this->withSession(['error' => 'Only this visitor sees a saved error'])
        ->get('/en/contact')->assertOk()->assertHeaderMissing('X-Sahra-Page-Cache')
        ->assertSee('Only this visitor sees a saved error');
});

it('invalidates cached HTML on an editorial update and serves each locale independently', function (): void {
    $page = Page::factory()->create(['key' => 'services']);
    $page->setTranslations(['en' => ['title' => 'Original services'], 'fa' => ['title' => 'خدمات فارسی']]);

    $this->get('/en/services')->assertHeader('X-Sahra-Page-Cache', 'MISS')->assertSee('Original services');
    $this->get('/en/services')->assertHeader('X-Sahra-Page-Cache', 'HIT');
    $this->get('/fa/services')->assertHeader('X-Sahra-Page-Cache', 'MISS')->assertSee('خدمات فارسی');

    DB::transaction(fn () => $page->setTranslations(['en' => ['title' => 'Published update']]));

    $this->get('/en/services')->assertHeader('X-Sahra-Page-Cache', 'MISS')
        ->assertSee('Published update')->assertDontSee('Original services');
    $this->get('/en/services?utm_source=test')->assertHeaderMissing('X-Sahra-Page-Cache');
});
