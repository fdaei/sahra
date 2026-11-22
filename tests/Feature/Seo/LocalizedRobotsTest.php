<?php

declare(strict_types=1);

use App\Filament\Support\TranslatableForm;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\DomCrawler\Crawler;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
});

it('applies per-language robots directives in HTML and Inertia while preserving the language switcher', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations([
        'en' => ['title' => 'English', 'slug' => 'english'],
        'fa' => ['title' => 'فارسی', 'slug' => 'farsi', 'seo_noindex' => true, 'seo_nofollow' => true],
    ]);
    $dom = new Crawler($this->get('/fa/insights/farsi')->assertOk()->getContent());
    expect($dom->filter('meta[name="robots"]')->attr('content'))->toBe('noindex, nofollow')
        ->and($dom->filter('head link[hreflang]')->count())->toBe(0);
    $this->get('/fa/insights/farsi')->assertOk()->assertInertia(fn (Assert $page) => $page
        ->where('seo.noindex', true)->where('seo.nofollow', true)->has('alternates.en'));
    $dom = new Crawler($this->get('/en/insights/english')->assertOk()->getContent());
    expect($dom->filter('head link[hreflang="fa"]')->count())->toBe(0)
        ->and($dom->filter('head link[hreflang="en"]')->count())->toBe(1);
    $this->get('/sitemap-fa.xml')->assertOk()->assertDontSee('/fa/insights/farsi');
    $this->get('/sitemap-en.xml')->assertOk()->assertSee('/en/insights/english')->assertDontSee('/fa/insights/farsi');
});

it('applies independent nofollow and noindex to pages and projects', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About', 'seo_noindex' => true, 'seo_nofollow' => true], 'fa' => ['title' => 'درباره']]);
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project', 'seo_nofollow' => true], 'fa' => ['title' => 'پروژه', 'slug' => 'project-fa', 'seo_noindex' => true]]);
    $pageDom = new Crawler($this->get('/en/about')->assertOk()->getContent());
    $projectDom = new Crawler($this->get('/en/work/project')->assertOk()->getContent());
    expect($pageDom->filter('meta[name="robots"]')->attr('content'))->toBe('noindex, nofollow')
        ->and($projectDom->filter('meta[name="robots"]')->attr('content'))->toBe('index, nofollow, max-image-preview:large')
        ->and($projectDom->filter('head link[hreflang="fa"]')->count())->toBe(0);
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/about')->assertSee('/en/work/project');
    $this->get('/sitemap-fa.xml')->assertOk()->assertSee('/fa/about')->assertDontSee('/fa/work/project-fa');
});

it('does not create empty translations from untouched SEO toggles', function (): void {
    $post = Post::factory()->create();
    TranslatableForm::persist($post, [
        'en' => ['title' => 'Title', 'slug' => 'title', 'seo_noindex' => true, 'seo_nofollow' => false],
        'fa' => ['title' => null, 'slug' => null, 'seo_noindex' => false, 'seo_nofollow' => false],
    ]);
    expect($post->translations()->count())->toBe(1)
        ->and((bool) $post->getTranslation('seo_noindex', 'en'))->toBeTrue();
});

it('uses localized social overrides without changing search metadata or article schema', function (): void {
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations([
        'en' => ['title' => 'Article', 'slug' => 'article', 'excerpt' => 'Search description', 'seo_title' => 'Search title', 'seo_social_title' => 'Social title', 'seo_social_description' => 'Social description', 'seo_social_image' => 'seo/social/share.jpg'],
        'fa' => ['title' => 'مقاله', 'slug' => 'article-fa', 'excerpt' => 'توضیح'],
    ]);
    $response = $this->get('/en/insights/article')->assertOk();
    $dom = new Crawler($response->getContent());
    expect($dom->filter('title')->text())->toBe('Search title')
        ->and($dom->filter('meta[name="description"]')->attr('content'))->toBe('Search description')
        ->and($dom->filter('meta[property="og:title"]')->attr('content'))->toBe('Social title')
        ->and($dom->filter('meta[property="og:description"]')->attr('content'))->toBe('Social description')
        ->and($dom->filter('meta[property="og:image"]')->attr('content'))->toBe('https://seo.example/storage/seo/social/share.jpg')
        ->and($dom->filter('meta[name="twitter:image"]')->attr('content'))->toBe('https://seo.example/storage/seo/social/share.jpg');
    $schema = $dom->filter('script[type="application/ld+json"]')->each(fn ($node) => json_decode($node->text(), true, flags: JSON_THROW_ON_ERROR));
    expect(collect($schema)->firstWhere('@type', 'Article')['image'])->toBe(['https://seo.example/storage/posts/cover.jpg']);
    $fa = new Crawler($this->get('/fa/insights/article-fa')->assertOk()->getContent());
    expect($fa->filter('meta[property="og:title"]')->attr('content'))->toBe('مقاله')
        ->and($fa->filter('meta[property="og:image"]')->attr('content'))->toBe('https://seo.example/storage/posts/cover.jpg');
});

it('saves localized SEO controls through the post editor', function (): void {
    $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    $admin = \App\Models\User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    \Livewire\Livewire::actingAs($admin)
        ->test(\App\Filament\Resources\PostResource\Pages\EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm(['translations' => ['en' => [
            'title' => 'Article', 'slug' => 'article', 'seo_noindex' => true,
            'seo_nofollow' => true, 'seo_social_title' => 'Share title',
            'seo_social_description' => 'Share description',
        ]]])
        ->call('save')->assertHasNoFormErrors();
    $post->refresh();
    expect((bool) $post->getTranslation('seo_noindex', 'en'))->toBeTrue()
        ->and((bool) $post->getTranslation('seo_nofollow', 'en'))->toBeTrue()
        ->and($post->getTranslation('seo_social_title', 'en'))->toBe('Share title');
});
