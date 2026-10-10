<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Project;
use App\Services\MediaTransformer;
use Inertia\Ssr\Gateway;
use Inertia\Ssr\Response as SsrResponse;

/*
| The production host cannot run the Node SSR process, so these pin down what
| a crawler reading the raw HTML gets without it: the SEO head from
| resources/views/seo/head.blade.php and the page copy from seo/body.
*/

beforeEach(function (): void {
    $this->withoutVite();
    $this->seed();

    // Point SSR at a closed port: dispatch() returns null exactly as it does
    // on the shared host.
    config([
        'inertia.ssr.enabled' => true,
        'inertia.ssr.url' => 'http://127.0.0.1:9',
        'inertia.ssr.ensure_bundle_exists' => false,
    ]);
});

/**
 * @return list<array<string, mixed>>
 */
function jsonLd(string $html): array
{
    preg_match_all('#<script inertia type="application/ld\+json">(.*?)</script>#s', $html, $matches);

    return array_map(fn (string $json): array => json_decode($json, true, flags: JSON_THROW_ON_ERROR), $matches[1]);
}

it('serves the page instead of a 503 when SSR is unavailable', function (): void {
    $this->get('/en')->assertOk()->assertDontSee('errors.503', false);
});

it('puts the SEO head and the page copy in the initial HTML', function (): void {
    $html = $this->get('/en')->assertOk()->getContent();

    expect($html)
        ->toContain('<title inertia>Sahra — Digital Marketing Agency in Muscat</title>')
        ->toMatch('#<meta inertia name="description" content="[^"]{50,}">#')
        ->toContain('<link inertia rel="canonical" href="'.config('app.url').'/en">')
        ->toContain('<meta inertia name="robots" content="index, follow, max-image-preview:large">')
        ->toMatch('#<meta inertia property="og:image" content="https?://[^"]+">#')
        ->toContain('<div data-seo-fallback>')
        ->toContain('<h1>We build marketing systems for brands ready to grow</h1>');

    expect(substr_count($html, '<h1>'))->toBe(1);
    expect(array_column(jsonLd($html), '@type'))->toBe(['Organization', 'WebSite']);
});

it('renders the fallback in the visitor\'s language', function (): void {
    $html = $this->get('/fa')->assertOk()->getContent();

    expect($html)
        ->toContain('<title inertia>صحرا — آژانس بازاریابی دیجیتال در مسقط</title>')
        ->toContain('<link inertia rel="canonical" href="'.config('app.url').'/fa">');
});

it('links calls to action straight to the localised URL', function (): void {
    $html = $this->get('/en')->getContent();

    expect($html)
        ->toContain('<a href="/en/contact">')
        ->not->toContain('<a href="/contact">');
});

it('describes a case study with breadcrumbs and an absolute share image', function (): void {
    $project = Project::query()->published()->firstOrFail();
    $html = $this->get($project->url(absolute: false))->assertOk()->getContent();

    expect($html)
        ->toContain('<h1>'.e($project->getTranslation('title')).'</h1>')
        ->toMatch('#<meta inertia property="og:image" content="https?://[^"]+">#');

    $breadcrumbs = collect(jsonLd($html))->firstWhere('@type', 'BreadcrumbList');
    expect(array_column($breadcrumbs['itemListElement'], 'name'))
        ->toBe(['Sahra', 'Projects', $project->getTranslation('title')]);
});

it('marks up an article with its unbranded headline and body', function (): void {
    $post = Post::query()->published()->firstOrFail();
    $html = $this->get($post->url(absolute: false))->assertOk()->getContent();

    $article = collect(jsonLd($html))->firstWhere('@type', 'Article');

    expect($article['headline'])->toBe($post->getTranslation('title'));
    expect($html)
        ->toContain('<title inertia>'.e($post->getTranslation('title')).' | Sahra</title>')
        ->toContain('<meta inertia property="og:type" content="article">')
        ->toContain('<h1>'.e($post->getTranslation('title')).'</h1>');
});

it('keeps filtered and paginated listings out of the index but crawlable', function (): void {
    $this->get('/en/insights?page=2')
        ->assertOk()
        ->assertSee('<meta inertia name="robots" content="noindex, follow">', false);
});

it('marks error pages noindex', function (): void {
    $html = $this->get('/en/no-such-page')->assertNotFound()->getContent();

    expect($html)
        ->toContain('<meta inertia name="robots" content="noindex, follow">')
        ->toContain('<h1>'.e(__('errors.404.title')).'</h1>');
});

it('uses the SSR render instead of the fallback when SSR answers', function (): void {
    $this->app->instance(Gateway::class, new class implements Gateway
    {
        public function dispatch(array $page): ?SsrResponse
        {
            return new SsrResponse('<title inertia>From SSR</title>', '<div id="app">rendered by node</div>');
        }
    });

    $this->get('/en')
        ->assertOk()
        ->assertSee('<title inertia>From SSR</title>', false)
        ->assertSee('rendered by node', false)
        ->assertDontSee('data-seo-fallback', false);
});

it('only references image widths the variant route serves', function (): void {
    foreach (array_keys(MediaTransformer::DIMENSIONS) as $context) {
        $image = MediaTransformer::make('projects/example.webp', null, $context);

        preg_match('#/media/jpeg/(\d+)/#', $image['src'], $match);
        expect(MediaTransformer::VARIANT_WIDTHS)->toContain((int) $match[1]);
    }
});
