<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null, 'seo.sitemap_chunk_size' => 2]);
});

function sitemapLocations(string $xml): array
{
    $dom = new DOMDocument;
    $dom->loadXML($xml, LIBXML_NONET);
    $xpath = new DOMXPath($dom);
    $xpath->registerNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    return array_map(fn (DOMNode $node): string => $node->textContent, iterator_to_array($xpath->query('//s:loc')));
}

it('publishes bounded stable shards with eligible localized content', function (): void {
    Page::factory()->create(['key' => 'about'])->setTranslations(['en' => ['title' => 'About'], 'fa' => ['title' => 'درباره']]);
    Post::factory()->published()->create()->setTranslations(['en' => ['title' => 'One', 'slug' => 'one'], 'fa' => ['title' => 'یک', 'slug' => 'one-fa']]);
    Post::factory()->published()->create()->setTranslations(['en' => ['title' => 'Two', 'slug' => 'two']]);
    Post::factory()->published()->create()->setTranslations(['en' => ['title' => 'Hidden', 'slug' => 'hidden', 'seo_noindex' => true]]);
    Post::factory()->published()->create()->setTranslations(['en' => ['title' => 'Duplicate', 'slug' => 'duplicate', 'seo_canonical_url' => 'https://other.example/source']]);
    Post::factory()->create()->setTranslations(['en' => ['title' => 'Draft', 'slug' => 'draft']]);
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $index = sitemapLocations($this->get('/sitemap.xml')->assertOk()->getContent());
    expect($index)->toContain('https://seo.example/sitemap-en.xml', 'https://seo.example/sitemap-en-post-1.xml', 'https://seo.example/sitemap-en-post-2.xml', 'https://seo.example/sitemap-en-project-1.xml', 'https://seo.example/sitemap-fa-post-1.xml')
        ->not->toContain('https://seo.example/sitemap-en-post-3.xml');
    $main = sitemapLocations($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($main)->toContain('https://seo.example/en/about')->not->toContain('https://seo.example/en/insights/one');
    $firstResponse = $this->get('/sitemap-en-post-1.xml')->assertOk();
    $first = sitemapLocations($firstResponse->getContent());
    expect($first)->toBe(['https://seo.example/en/insights/one', 'https://seo.example/en/insights/two']);
    $firstResponse->assertSee('https://seo.example/fa/insights/one-fa');
    expect(sitemapLocations($this->get('/sitemap-en-post-2.xml')->assertOk()->getContent()))->toBe([])
        ->and(sitemapLocations($this->get('/sitemap-en-project-1.xml')->assertOk()->getContent()))->toBe(['https://seo.example/en/work/project'])
        ->and(sitemapLocations($this->get('/sitemap-fa-post-1.xml')->assertOk()->getContent()))->toBe(['https://seo.example/fa/insights/one-fa']);
});

it('keeps the legacy localized sitemap for small sites', function (): void {
    config(['seo.sitemap_chunk_size' => 20]);
    Post::factory()->published()->create()->setTranslations(['en' => ['title' => 'One', 'slug' => 'one']]);
    expect(sitemapLocations($this->get('/sitemap-en.xml')->assertOk()->getContent()))->toContain('https://seo.example/en/insights/one');
    expect(sitemapLocations($this->get('/sitemap.xml')->assertOk()->getContent()))->not->toContain('https://seo.example/sitemap-en-post-1.xml');
});

it('rejects invalid shard routes safely', function (): void {
    $this->get('/sitemap-en-post-0.xml')->assertNotFound();
    $this->get('/sitemap-en-post-9999999999999999999999999999.xml')->assertNotFound();
    $this->get('/sitemap-en-unknown-1.xml')->assertNotFound();
    $this->get('/sitemap-zz-post-1.xml')->assertNotFound();
});

it('does not query missing translations once per article', function (): void {
    config(['seo.sitemap_chunk_size' => 20]);
    for ($i = 0; $i < 20; $i++) {
        Post::factory()->published()->create()->setTranslations(['en' => ['title' => "Post {$i}", 'slug' => "post-{$i}"]]);
    }
    \Illuminate\Support\Facades\DB::flushQueryLog();
    \Illuminate\Support\Facades\DB::enableQueryLog();
    try {
        $response = $this->get('/sitemap-en-post-1.xml')->assertOk();
        $queryCount = count(\Illuminate\Support\Facades\DB::getQueryLog());
    } finally {
        \Illuminate\Support\Facades\DB::disableQueryLog();
    }
    expect(sitemapLocations($response->getContent()))->toHaveCount(20)
        ->and($queryCount)->toBeLessThan(10);
});
