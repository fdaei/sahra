<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

function articleSchemaNodes(string $html): array
{
    return (new Crawler($html))->filter('script[type="application/ld+json"]')
        ->each(fn ($node) => json_decode($node->text(), true, flags: JSON_THROW_ON_ERROR));
}

it('renders the selected article schema type in every translation', function (string $type): void {
    $post = Post::factory()->published()->create(['seo_schema_type' => $type, 'cover_path' => 'posts/cover.jpg']);
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title', 'excerpt' => 'Summary'], 'fa' => ['title' => 'مقاله', 'slug' => 'title-fa']]);
    foreach (['/en/insights/title', '/fa/insights/title-fa'] as $url) {
        $nodes = articleSchemaNodes($this->get($url)->assertOk()->getContent());
        $article = collect($nodes)->firstWhere('@type', $type);
        expect($article)->not->toBeNull()->and($article['headline'])->not->toBeEmpty()->and($article['image'])->not->toBeEmpty();
    }
})->with(['Article', 'BlogPosting', 'NewsArticle']);

it('can disable the article schema while retaining other metadata', function (): void {
    $post = Post::factory()->published()->create(['seo_schema_type' => 'none']);
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    $response = $this->get('/en/insights/title')->assertOk();
    $nodes = collect(articleSchemaNodes($response->getContent()));
    expect($nodes->pluck('@type')->all())->not->toContain('Article', 'BlogPosting', 'NewsArticle')->toContain('Organization', 'WebSite');
    expect((new Crawler($response->getContent()))->filter('meta[property="og:type"]')->attr('content'))->toBe('article');
});

it('saves the schema choice in the editor and rejects invalid values', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['seo_schema_type' => 'NewsArticle'])->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->seo_schema_type)->toBe('NewsArticle');
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['seo_schema_type' => 'Product'])->call('save')->assertHasFormErrors(['seo_schema_type']);
    expect($post->refresh()->seo_schema_type)->toBe('NewsArticle');
});

it('falls back safely when an invalid schema type already exists in storage', function (): void {
    $post = Post::factory()->published()->create(['seo_schema_type' => 'invalid']);
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    $nodes = collect(articleSchemaNodes($this->get('/en/insights/title')->assertOk()->getContent()));
    expect($nodes->pluck('@type')->all())->toContain('Article')->not->toContain('invalid');
});
