<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use App\Models\Page;
use App\Models\Post;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\DomCrawler\Crawler;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
});

function parseRss(string $body): SimpleXMLElement
{
    $xml = simplexml_load_string($body, SimpleXMLElement::class, LIBXML_NONET);
    expect($xml)->not->toBeFalse();
    return $xml;
}

it('returns valid localized RSS with safe text and stable identifiers', function (): void {
    $post = Post::factory()->published()->create(['published_at' => now()->subDay()]);
    $post->setTranslations([
        'en' => ['title' => 'A & B', 'slug' => 'article', 'excerpt' => '<b>Summary &amp; details</b><script>secret()</script>'],
        'fa' => ['title' => 'خبر فارسی', 'slug' => 'persian', 'excerpt' => 'متن فارسی'],
    ]);
    $response = $this->get('/feed-en.xml')->assertOk()->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
    $xml = parseRss($response->getContent());
    expect((string) $xml->channel->item[0]->title)->toBe('A & B')
        ->and((string) $xml->channel->item[0]->description)->toBe('Summary & details')
        ->and((string) $xml->channel->item[0]->link)->toBe('https://seo.example/en/insights/article')
        ->and((string) $xml->channel->item[0]->guid['isPermaLink'])->toBe('false')
        ->and(strtotime((string) $xml->channel->item[0]->pubDate))->toBe($post->published_at->timestamp)
        ->and($response->getContent())->not->toContain('secret()');
    $guid = (string) $xml->channel->item[0]->guid;
    $post->setTranslations(['en' => ['slug' => 'renamed']]);
    $newFeed = parseRss($this->get('/feed-en.xml')->assertOk()->getContent());
    expect((string) $newFeed->channel->item[0]->guid)->toBe($guid)
        ->and((string) $newFeed->channel->item[0]->link)->toBe('https://seo.example/en/insights/renamed');
    $fa = parseRss($this->get('/feed-fa.xml')->assertOk()->getContent());
    expect((string) $fa->channel->item[0]->title)->toBe('خبر فارسی')
        ->and((string) $fa->channel->language)->toBe('fa');
});

it('never exposes unpublished, noindex, missing-language or noncanonical entries', function (): void {
    foreach (['draft', 'scheduled', 'future', 'deleted', 'noindex', 'canonical', 'missing'] as $state) {
        $post = Post::factory()->published()->create();
        $post->setTranslations([$state === 'missing' ? 'fa' : 'en' => ['title' => "Hidden {$state}", 'slug' => "hidden-{$state}"]]);
        match ($state) {
            'draft' => $post->update(['status' => PublicationStatus::Draft]),
            'scheduled' => $post->update(['status' => PublicationStatus::Scheduled, 'published_at' => now()->addDay()]),
            'future' => $post->update(['published_at' => now()->addDay()]),
            'deleted' => $post->delete(),
            'noindex' => $post->setTranslations(['en' => ['seo_noindex' => true]]),
            'canonical' => $post->setTranslations(['en' => ['seo_canonical_url' => 'https://other.example/article']]),
            default => null,
        };
    }
    $visible = Post::factory()->published()->create();
    $visible->setTranslations(['en' => ['title' => 'Visible', 'slug' => 'visible']]);
    $response = $this->get('/feed-en.xml')->assertOk()->assertDontSee('Hidden');
    $xml = parseRss($response->getContent());
    expect($xml->channel->item)->toHaveCount(1)->and((string) $xml->channel->item[0]->title)->toBe('Visible');
});

it('finds up to 50 eligible items even when newer ones are noindex', function (): void {
    for ($i = 0; $i < 105; $i++) {
        Post::factory()->published()->create(['published_at' => now()->subMinutes($i)])->setTranslations(['en' => ['title' => "Hidden {$i}", 'slug' => "hidden-{$i}", 'seo_noindex' => true]]);
    }
    for ($i = 0; $i < 52; $i++) {
        Post::factory()->published()->create(['published_at' => now()->subMinutes(200 + $i)])->setTranslations(['en' => ['title' => "Visible {$i}", 'slug' => "visible-{$i}"]]);
    }
    $xml = parseRss($this->get('/feed-en.xml')->assertOk()->getContent());
    expect($xml->channel->item)->toHaveCount(50)->and((string) $xml->channel->item[0]->title)->toBe('Visible 0')
        ->and((string) $xml->channel->item[49]->title)->toBe('Visible 49');
});

it('advertises the current language feed in public HTML and inertia', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About'], 'fa' => ['title' => 'درباره']]);
    $dom = new Crawler($this->get('/fa/about')->assertOk()->getContent());
    expect($dom->filter('head link[type="application/rss+xml"]')->attr('href'))->toBe('https://seo.example/feed-fa.xml');
    $this->get('/fa/about')->assertInertia(fn (Assert $page) => $page->where('rssFeedUrl', 'https://seo.example/feed-fa.xml'));
    $error = new Crawler($this->get('/en/missing')->assertNotFound()->getContent());
    expect($error->filter('head link[type="application/rss+xml"]')->count())->toBe(0);
    $this->get('/feed-zz.xml')->assertNotFound();
});
