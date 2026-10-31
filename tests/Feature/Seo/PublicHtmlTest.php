<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Filament\Support\TranslatableForm;
use App\Http\Middleware\HandleInertiaRequests;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

function publicHtml(string $html): Crawler
{
    $crawler = new Crawler($html);
    // Removing script nodes and data-page ensures JSON cannot satisfy a test.
    foreach ($crawler->filter('script') as $node) {
        $node->parentNode->removeChild($node);
    }
    foreach ($crawler->filter('[data-page]') as $node) {
        $node->removeAttribute('data-page');
    }

    return $crawler;
}

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
    Http::preventStrayRequests();
    foreach (['home', 'about', 'services', 'contact', 'work', 'insights', 'privacy-policy', 'terms'] as $key) {
        $page = Page::factory()->create(['key' => $key]);
        $page->setTranslations([
            'en' => ['title' => "Page {$key}", 'description' => "Description {$key}", 'content' => '<p>Full legal body</p>'],
            'fa' => ['title' => "صفحه {$key}", 'description' => 'توضیح فارسی', 'content' => '<p>متن کامل فارسی</p>'],
            'ar' => ['title' => "صفحة {$key}", 'description' => 'وصف عربي'],
        ]);
        $page->sections()->create(['type' => $key === 'about' ? SectionType::AboutHero : SectionType::Hero, 'is_visible' => true])
            ->setTranslations(['en' => ['title' => "Heading {$key}", 'content' => "<p>Editorial body {$key}</p>"]]);
    }
});

it('renders real initial HTML for every public page without a rendering service', function (string $path): void {
    $response = $this->get('/en'.$path)->assertOk();
    $dom = publicHtml($response->getContent());
    expect($dom->filter('body main h1')->count())->toBe(1)
        ->and($dom->filter('title')->text())->not->toBeEmpty()
        ->and($dom->filter('meta[name="description"]')->attr('content'))->not->toBeEmpty()
        ->and($dom->filter('link[rel="canonical"]')->attr('href'))->toBe('https://seo.example/en'.$path)
        ->and($dom->filter('link[hreflang="x-default"]')->attr('href'))->toBe('https://seo.example/en'.$path);
    if (in_array($path, ['', '/about'], true)) {
        expect($dom->filter('body main')->text())->toContain('Editorial body');
    }
    if (in_array($path, ['/terms', '/privacy-policy'], true)) {
        expect($dom->filter('body main')->text())->toContain('Full legal body');
    }
    Http::assertNothingSent();
})->with(['', '/about', '/services', '/contact', '/work', '/insights', '/terms', '/privacy-policy']);

it('renders full live article text, images and followable links outside JSON', function (): void {
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations(['en' => ['title' => 'Visible article', 'slug' => 'visible', 'excerpt' => 'Article excerpt', 'content' => '<h2>Body heading</h2><p>Full article final paragraph <a href="/en/services">Our services</a></p>', 'cover_alt' => 'Article cover']]);
    $list = publicHtml($this->get('/en/insights')->assertOk()->getContent());
    expect($list->filter('main a[href="/en/insights/visible"]')->text())->toContain('Visible article');
    $response = $this->get('/en/insights/visible')->assertOk();
    $dom = publicHtml($response->getContent());
    expect($dom->filter('main article')->text())->toContain('Full article final paragraph')
        ->and($dom->filter('main img[alt="Article cover"]')->count())->toBe(1)
        ->and($dom->filter('main a[href="/en/services"]')->count())->toBe(1)
        ->and($dom->filter('meta[property="og:image"]')->attr('content'))->toBe('https://seo.example/storage/posts/cover.jpg');
    $schema = (new Crawler($response->getContent()))->filter('script[type="application/ld+json"]')->each(fn ($node) => json_decode($node->text(), true, flags: JSON_THROW_ON_ERROR));
    expect(collect($schema)->firstWhere('@type', 'Article')['headline'])->toBe('Visible article');
    $post->setTranslations(['en' => ['title' => 'Edited article', 'content' => '<p>Updated immediately from admin</p>']]);
    $updated = publicHtml($this->get('/en/insights/visible')->assertOk()->getContent());
    expect($updated->filter('main')->text())->toContain('Updated immediately from admin')
        ->and($updated->filter('title')->text())->toBe('Edited article');
});

it('does not expose draft, future, scheduled or deleted articles anywhere', function (string $state): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Hidden secret article', 'slug' => 'secret', 'content' => '<p>Hidden full body</p>']]);
    match ($state) {
        'draft' => $post->update(['status' => PublicationStatus::Draft]),
        'future' => $post->update(['published_at' => now()->addDay()]),
        'scheduled' => $post->update(['status' => PublicationStatus::Scheduled, 'published_at' => now()->addDay()]),
        'deleted' => $post->delete(),
    };
    $this->get('/en/insights/secret')->assertNotFound();
    $this->get('/en')->assertOk()->assertDontSee('Hidden secret article');
    $this->get('/en/insights')->assertOk()->assertDontSee('Hidden secret article');
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/insights/secret');
})->with(['draft', 'future', 'scheduled', 'deleted']);

it('renders project details while omitting invisible sections and items in both responses', function (): void {
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Live project', 'slug' => 'live-project', 'challenge' => 'Complete challenge text', 'results_summary' => 'Real results']]);
    $visible = $project->sections()->create(['type' => SectionType::Goals, 'is_visible' => true]);
    $visible->items()->create(['is_visible' => true])->setTranslations(['en' => ['title' => 'Visible goal', 'description' => 'Full goal detail']]);
    $visible->items()->create(['is_visible' => false])->setTranslations(['en' => ['title' => 'Hidden goal']]);
    $hidden = $project->sections()->create(['type' => SectionType::Strategy, 'is_visible' => false]);
    $hidden->items()->create(['is_visible' => true])->setTranslations(['en' => ['title' => 'Hidden strategy']]);
    $response = $this->get('/en/work/live-project')->assertOk()->assertDontSee('Hidden goal')->assertDontSee('Hidden strategy');
    expect(publicHtml($response->getContent())->filter('main')->text())->toContain('Complete challenge text', 'Full goal detail', 'Real results');
    $this->get('/en/work/live-project', ['X-Inertia' => 'true', 'X-Inertia-Version' => app(HandleInertiaRequests::class)->version(request())])->assertOk()->assertDontSee('Hidden goal')->assertDontSee('Hidden strategy');
});

it('keeps published pages and real translated slugs in sitemap and hreflang', function (): void {
    Page::where('key', 'about')->first()->unpublish();
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'English', 'slug' => 'english'], 'fa' => ['title' => 'فارسی', 'slug' => 'farsi']]);
    $this->get('/en/about')->assertNotFound();
    $xml = $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/about')->assertSee('/en/insights/english')->getContent();
    expect(simplexml_load_string($xml))->not->toBeFalse();
    $dom = publicHtml($this->get('/fa/insights/farsi')->assertOk()->getContent());
    expect($dom->filter('html')->attr('lang'))->toBe('fa')
        ->and($dom->filter('html')->attr('dir'))->toBe('rtl')
        ->and($dom->filter('meta[property="og:locale"]')->attr('content'))->toBe('fa_IR')
        ->and($dom->filter('link[hreflang="en"]')->attr('href'))->toBe('https://seo.example/en/insights/english')
        ->and($dom->filter('link[hreflang="ar"]')->count())->toBe(0);
    $this->get('/ar/insights/english')->assertNotFound();
    $this->get('/robots.txt')->assertOk()->assertSee('Sitemap: https://seo.example/sitemap.xml');
});

it('uses unique pagination canonicals and excludes the featured post on subsequent pages', function (): void {
    for ($i = 0; $i < 12; $i++) {
        Post::factory()->published()->create(['is_featured' => $i === 0, 'published_at' => now()->subDays($i + 1)])
            ->setTranslations(['en' => ['title' => "Article {$i}", 'slug' => "article-{$i}"]]);
    }
    $first = publicHtml($this->get('/en/insights')->assertOk()->getContent());
    $second = publicHtml($this->get('/en/insights?page=2')->assertOk()->getContent());
    expect($first->filter('main a[href="/en/insights/article-0"]')->count())->toBe(1)
        ->and($second->filter('main')->text())->toContain('Article 10', 'Article 11')->not->toContain('Article 0')
        ->and($second->filter('link[rel="canonical"]')->attr('href'))->toBe('https://seo.example/en/insights?page=2')
        ->and($second->filter('meta[name="robots"]')->attr('content'))->toContain('index, follow');
    $this->get('/en/insights?page=999')->assertNotFound();
    $filtered = publicHtml($this->get('/en/insights?q=Article')->assertOk()->getContent());
    expect($filtered->filter('meta[name="robots"]')->attr('content'))->toBe('noindex, follow');
});

it('returns real noindex 404 pages for unknown URLs in the requested language', function (string $path): void {
    $dom = publicHtml($this->get($path)->assertNotFound()->getContent());
    expect($dom->filter('meta[name="robots"]')->attr('content'))->toBe('noindex, follow')
        ->and($dom->filter('link[rel="canonical"]')->count())->toBe(0)
        ->and($dom->filter('link[hreflang]')->count())->toBe(0)
        ->and($dom->filter('body main h1')->count())->toBe(1);
    if (str_starts_with($path, '/fa/')) {
        expect($dom->filter('html')->attr('dir'))->toBe('rtl');
    }
})->with(['/en/missing', '/fa/missing', '/unknown', '/en/insights/missing']);

it('serves the same public body to visitors and crawlers', function (): void {
    $visitor = publicHtml($this->get('/en')->assertOk()->getContent())->filter('main')->text();
    $crawler = publicHtml($this->get('/en', ['User-Agent' => 'Googlebot'])->assertOk()->getContent())->filter('main')->text();
    expect($visitor)->toBe($crawler);
    $this->get('/admin/login')->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
});

it('requires a nonempty value in the requested translation without adding publication policy', function (): void {
    $valid = Post::factory()->published()->create();
    $valid->setTranslations(['en' => ['title' => 'English', 'slug' => 'valid-en'], 'fa' => ['title' => 'فارسی', 'slug' => 'valid-fa']]);
    $empty = Post::factory()->published()->create();
    $empty->setTranslations(['en' => ['title' => 'Empty slug', 'slug' => '']]);
    Post::factory()->published()->create(); // No translation row.
    $draft = Post::factory()->create();
    $draft->setTranslations(['en' => ['title' => 'Draft', 'slug' => 'valid-draft']]);
    expect(Post::query()->hasTranslatedValue('slug', 'en')->pluck('id')->all())->toBe([$valid->id, $draft->id])
        ->and(Post::query()->hasTranslatedValue('slug', 'ar')->count())->toBe(0);
    app()->setLocale('fa');
    expect(Post::query()->hasTranslatedValue('slug')->pluck('id')->all())->toBe([$valid->id]);
});

it('reflects category edits from the admin translation writer in the next HTML response', function (): void {
    $category = PostCategory::create(['sort_order' => 1]);
    TranslatableForm::persist($category, ['en' => ['name' => 'Original category', 'slug' => 'category']]);
    expect(publicHtml($this->get('/en/insights')->assertOk()->getContent())->filter('main')->text())->toContain('Original category');
    TranslatableForm::persist($category, ['en' => ['name' => 'Edited category', 'slug' => 'category']]);
    expect(publicHtml($this->get('/en/insights')->assertOk()->getContent())->filter('main')->text())->toContain('Edited category')->not->toContain('Original category');
});
