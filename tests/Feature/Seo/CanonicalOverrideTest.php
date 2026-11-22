<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use App\Filament\Resources\PostResource\Pages\EditPost;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
});

it('applies a canonical to one language and excludes only that duplicate from sitemap and hreflang', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations([
        'en' => ['title' => 'English', 'slug' => 'article', 'seo_canonical_url' => 'https://other.example/preferred?source=article'],
        'fa' => ['title' => 'فارسی', 'slug' => 'fa-article'],
    ]);
    $response = $this->get('/en/insights/article')->assertOk();
    $dom = new Crawler($response->getContent());
    expect($dom->filter('link[rel="canonical"]')->attr('href'))->toBe('https://other.example/preferred?source=article')
        ->and($dom->filter('meta[property="og:url"]')->attr('content'))->toBe('https://other.example/preferred?source=article')
        ->and($dom->filter('head link[hreflang]')->count())->toBe(0);
    $schema = $dom->filter('script[type="application/ld+json"]')->each(fn ($node) => json_decode($node->text(), true, flags: JSON_THROW_ON_ERROR));
    expect(collect($schema)->firstWhere('@type', 'Article')['mainEntityOfPage']['@id'])->toBe('https://other.example/preferred?source=article');
    $fa = new Crawler($this->get('/fa/insights/fa-article')->assertOk()->getContent());
    expect($fa->filter('link[rel="canonical"]')->attr('href'))->toBe('https://seo.example/fa/insights/fa-article')
        ->and($fa->filter('head link[hreflang="en"]')->count())->toBe(0)
        ->and($fa->filter('head link[hreflang="fa"]')->count())->toBe(1);
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/insights/article');
    $this->get('/sitemap-fa.xml')->assertOk()->assertSee('/fa/insights/fa-article')->assertDontSee('/en/insights/article');
});

it('keeps self canonicals in the sitemap and applies canonical overrides to pages and projects', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About', 'seo_canonical_url' => 'https://other.example/about']]);
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project', 'seo_canonical_url' => 'https://SEO.EXAMPLE:443/en/work/project/']]);
    $about = new Crawler($this->get('/en/about')->assertOk()->getContent());
    $work = new Crawler($this->get('/en/work/project')->assertOk()->getContent());
    expect($about->filter('link[rel="canonical"]')->attr('href'))->toBe('https://other.example/about')
        ->and($work->filter('link[rel="canonical"]')->attr('href'))->toBe('https://SEO.EXAMPLE:443/en/work/project/');
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/about')->assertSee('/en/work/project');
});

it('does not apply listing page canonical overrides to pagination', function (): void {
    $page = Page::factory()->create(['key' => 'insights']);
    $page->setTranslations(['en' => ['title' => 'Articles', 'seo_canonical_url' => 'https://other.example/articles']]);
    for ($i = 0; $i < 12; $i++) {
        Post::factory()->published()->create()->setTranslations(['en' => ['title' => "Article {$i}", 'slug' => "article-{$i}"]]);
    }
    $first = new Crawler($this->get('/en/insights')->assertOk()->getContent());
    $second = new Crawler($this->get('/en/insights?page=2')->assertOk()->getContent());
    expect($first->filter('link[rel="canonical"]')->attr('href'))->toBe('https://other.example/articles')
        ->and($second->filter('link[rel="canonical"]')->attr('href'))->toBe('https://seo.example/en/insights?page=2');
});

it('rejects unsafe canonical input in the editor and ignores invalid stored values', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_canonical_url' => 'javascript:alert(1)']]])
        ->call('save')->assertHasFormErrors(['translations.en.seo_canonical_url']);
    $post->setTranslations(['en' => ['seo_canonical_url' => 'https://user:pass@other.example/path#part']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('link[rel="canonical"]')->attr('href'))->toBe('https://seo.example/en/insights/article');
});

it('saves a valid canonical URL through the post editor', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_canonical_url' => 'https://example.org/post?contact=a@example.org']]])
        ->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->getTranslation('seo_canonical_url', 'en'))->toBe('https://example.org/post?contact=a@example.org');
});
