<?php

declare(strict_types=1);

use App\Models\Post;
use App\Models\Project;
use App\Services\MediaTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
    Storage::fake('public');
});

function sitemapImageEntries(string $xml): array
{
    $dom = new DOMDocument;
    expect($dom->loadXML($xml, LIBXML_NONET))->toBeTrue();
    $xpath = new DOMXPath($dom);
    $xpath->registerNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xpath->registerNamespace('i', 'http://www.google.com/schemas/sitemap-image/1.1');
    $result = [];
    foreach ($xpath->query('/s:urlset/s:url') as $node) {
        $loc = $xpath->query('./s:loc', $node)->item(0)->textContent;
        $result[$loc] = array_map(fn (DOMNode $image): string => $image->textContent, iterator_to_array($xpath->query('./i:image/i:loc', $node)));
    }
    return $result;
}

it('lists actual public images of published, indexable posts and projects', function (): void {
    foreach (['posts/cover.jpg', 'projects/banner.jpg', 'projects/before.jpg', 'projects/after.jpg', 'projects/gallery.jpg'] as $path) {
        Storage::disk('public')->put($path, 'image');
    }
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    $project = Project::factory()->published()->create(['banner_path' => 'projects/banner.jpg', 'before_image_path' => 'projects/before.jpg', 'after_image_path' => 'projects/after.jpg']);
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $project->images()->create(['path' => 'projects/gallery.jpg', 'sort_order' => 1]);
    $project->images()->create(['path' => 'projects/missing.jpg', 'sort_order' => 2]);
    $project->images()->create(['path' => 'projects/gallery.jpg', 'sort_order' => 3]);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($entries['https://seo.example/en/insights/article'])->toBe(['https://seo.example'.MediaTransformer::primaryUrl('posts/cover.jpg', 'post.hero')])
        ->and($entries['https://seo.example/en/work/project'])->toBe([
            'https://seo.example'.MediaTransformer::primaryUrl('projects/banner.jpg', 'project.banner'),
            'https://seo.example'.MediaTransformer::primaryUrl('projects/before.jpg', 'project.beforeafter'),
            'https://seo.example'.MediaTransformer::primaryUrl('projects/after.jpg', 'project.beforeafter'),
            'https://seo.example'.MediaTransformer::primaryUrl('projects/gallery.jpg', 'project.showcase'),
        ]);
});

it('respects noimageindex per language without excluding the page', function (): void {
    Storage::disk('public')->put('posts/cover.jpg', 'image');
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article', 'seo_noimageindex' => true], 'fa' => ['title' => 'مقاله', 'slug' => 'article-fa']]);
    $en = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    $fa = sitemapImageEntries($this->get('/sitemap-fa.xml')->assertOk()->getContent());
    expect($en['https://seo.example/en/insights/article'])->toBe([])
        ->and($fa['https://seo.example/fa/insights/article-fa'])->toHaveCount(1);
});

it('excludes images from unpublished, noindex and noncanonical content', function (): void {
    Storage::disk('public')->put('posts/cover.jpg', 'image');
    foreach (['draft', 'noindex', 'canonical'] as $state) {
        $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
        $post->setTranslations(['en' => ['title' => $state, 'slug' => $state]]);
        if ($state === 'draft') $post->update(['status' => \App\Enums\PublicationStatus::Draft]);
        if ($state === 'noindex') $post->setTranslations(['en' => ['seo_noindex' => true]]);
        if ($state === 'canonical') $post->setTranslations(['en' => ['seo_canonical_url' => 'https://other.example/article']]);
    }
    $response = $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/insights/draft')->assertDontSee('/en/insights/noindex')->assertDontSee('/en/insights/canonical');
    expect(sitemapImageEntries($response->getContent()))->toBe([]);
});

it('supports external and SVG images and escapes XML safely', function (): void {
    Storage::disk('public')->put('posts/example.svg', '<svg/>');
    $post = Post::factory()->published()->create(['cover_path' => 'posts/example.svg']);
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    $project = Project::factory()->published()->create(['banner_path' => 'https://cdn.example/image.jpg?a=1&b=2']);
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($entries['https://seo.example/en/insights/article'])->toBe(['https://seo.example/storage/posts/example.svg'])
        ->and($entries['https://seo.example/en/work/project'])->toBe(['https://cdn.example/image.jpg?a=1&b=2']);
});

it('bounds project shards and avoids per-project gallery queries', function (): void {
    for ($i = 1; $i <= 6; $i++) {
        $path = "projects/{$i}.jpg";
        Storage::disk('public')->put($path, 'image');
        $project = Project::factory()->published()->create();
        $project->setTranslations(['en' => ['title' => "Project {$i}", 'slug' => "project-{$i}"]]);
        $project->images()->create(['path' => $path]);
    }
    $index = $this->get('/sitemap.xml')->assertOk();
    $index->assertSee('/sitemap-en-project-1.xml')->assertSee('/sitemap-en-project-2.xml');
    DB::flushQueryLog();
    DB::enableQueryLog();
    try {
        $response = $this->get('/sitemap-en-project-1.xml')->assertOk();
        $queries = count(DB::getQueryLog());
    } finally {
        DB::disableQueryLog();
    }
    $first = sitemapImageEntries($response->getContent());
    $second = sitemapImageEntries($this->get('/sitemap-en-project-2.xml')->assertOk()->getContent());
    expect($first)->toHaveCount(5)->and($second)->toHaveCount(1)->and($queries)->toBeLessThan(10);
    foreach ([...array_values($first), ...array_values($second)] as $images) expect($images)->toHaveCount(1);
});

it('limits each project to 1000 unique images and keeps their ordering', function (): void {
    Storage::disk('public')->put('projects/banner.jpg', 'image');
    $project = Project::factory()->published()->create(['banner_path' => 'projects/banner.jpg']);
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $rows = [];
    for ($i = 0; $i < 1002; $i++) {
        $path = "projects/gallery-{$i}.jpg";
        Storage::disk('public')->put($path, 'image');
        $rows[] = ['project_id' => $project->id, 'path' => $path, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()];
    }
    foreach (array_chunk($rows, 100) as $chunk) DB::table('project_images')->insert($chunk);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    $images = $entries['https://seo.example/en/work/project'];
    expect($images)->toHaveCount(1000)
        ->and($images[0])->toBe('https://seo.example'.MediaTransformer::primaryUrl('projects/banner.jpg', 'project.banner'))
        ->and($images[999])->toBe('https://seo.example'.MediaTransformer::primaryUrl('projects/gallery-998.jpg', 'project.showcase'));
});

it('uses the same primary URLs as the public image transformer', function (string $path, string $context): void {
    expect(MediaTransformer::primaryUrl($path, $context))->toBe(MediaTransformer::make($path, 'description', $context)['src']);
})->with([
    ['posts/photo.jpg', 'post.hero'], ['projects/photo.jpg', 'project.showcase'],
    ['projects/logo.svg', 'project.banner'], ['https://cdn.example/photo.jpg', 'project.banner'],
]);

it('continues past missing gallery rows to include later existing images', function (): void {
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $rows = [];
    for ($i = 0; $i < 1002; $i++) {
        $path = "projects/gallery-{$i}.jpg";
        if ($i >= 1000) Storage::disk('public')->put($path, 'image');
        $rows[] = ['project_id' => $project->id, 'path' => $path, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()];
    }
    foreach (array_chunk($rows, 100) as $chunk) DB::table('project_images')->insert($chunk);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($entries['https://seo.example/en/work/project'])->toBe([
        'https://seo.example'.MediaTransformer::primaryUrl('projects/gallery-1000.jpg', 'project.showcase'),
        'https://seo.example'.MediaTransformer::primaryUrl('projects/gallery-1001.jpg', 'project.showcase'),
    ]);
});

it('encodes spaces, ampersands and Unicode in local image URLs', function (): void {
    Storage::disk('public')->put('posts/طرح & logo.svg', '<svg/>');
    $post = Post::factory()->published()->create(['cover_path' => 'posts/طرح & logo.svg']);
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($entries['https://seo.example/en/insights/article'])->toBe(['https://seo.example/storage/posts/%D8%B7%D8%B1%D8%AD%20%26%20logo.svg']);
});

it('preserves external image URLs with uppercase schemes', function (): void {
    $project = Project::factory()->published()->create(['banner_path' => 'HTTPS://cdn.example/image.jpg']);
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $entries = sitemapImageEntries($this->get('/sitemap-en.xml')->assertOk()->getContent());
    expect($entries['https://seo.example/en/work/project'])->toBe(['HTTPS://cdn.example/image.jpg']);
});
