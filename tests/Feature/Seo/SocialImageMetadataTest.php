<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
});

function socialMedia(string $path, string $alt = 'Library alt'): Media
{
    $media = Media::create(['path' => $path, 'name' => basename($path), 'mime' => 'image/jpeg', 'type' => 'image', 'size' => 10, 'width' => 1200, 'height' => 630]);
    $media->setTranslations(['en' => ['alt' => $alt], 'fa' => ['alt' => 'متن تصویر']]);
    return $media;
}

it('renders explicit localized social image alt and actual media dimensions', function (): void {
    socialMedia('seo/social/share.jpg');
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations([
        'en' => ['title' => 'Article', 'slug' => 'article', 'cover_alt' => 'Cover alt', 'seo_social_image' => 'seo/social/share.jpg', 'seo_social_image_alt' => 'People working together'],
        'fa' => ['title' => 'مقاله', 'slug' => 'article-fa', 'seo_social_image' => 'seo/social/share.jpg'],
    ]);
    $html = $this->get('/en/insights/article')->assertOk()->getContent();
    $dom = new Crawler($html);
    expect($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('People working together')
        ->and($dom->filter('meta[name="twitter:image:alt"]')->attr('content'))->toBe('People working together')
        ->and($dom->filter('meta[property="og:image:width"]')->attr('content'))->toBe('1200')
        ->and($dom->filter('meta[property="og:image:height"]')->attr('content'))->toBe('630')
        ->and($dom->filter('meta[property="og:image:type"]')->attr('content'))->toBe('image/jpeg');
    $this->get('/en/insights/article')->assertInertia(fn (Assert $page) => $page
        ->where('seo.socialImageAlt', 'People working together')->where('seo.socialImageWidth', 1200));
    $fa = new Crawler($this->get('/fa/insights/article-fa')->assertOk()->getContent());
    expect($fa->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('متن تصویر');
});

it('uses the cover alt or library alt only for the image actually shared', function (): void {
    socialMedia('posts/cover.jpg');
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article', 'cover_alt' => 'Editor cover alt']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('Editor cover alt');
    $post->setTranslations(['en' => ['cover_alt' => null]]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('Library alt');
    $post->setTranslations(['en' => ['seo_social_image' => 'seo/unregistered.jpg']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:image:alt"]')->count())->toBe(0)
        ->and($dom->filter('meta[property="og:image:width"]')->count())->toBe(0);
});

it('uses the site default image description when that image is selected', function (): void {
    socialMedia('seo/default.jpg');
    Setting::updateOrCreate(['key' => 'seo_default_image'], ['group' => 'seo', 'value' => ['value' => 'seo/default.jpg']]);
    Setting::updateOrCreate(['key' => 'seo_default_image_alt'], ['group' => 'seo', 'value' => ['en' => 'Default artwork']]);
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About']]);
    $dom = new Crawler($this->get('/en/about')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('Default artwork')
        ->and($dom->filter('meta[property="og:image:width"]')->attr('content'))->toBe('1200');
});

it('does not invent an image description or emit image metadata without an image', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article', 'seo_social_image_alt' => 'Orphan alt']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:image"]')->count())->toBe(0)
        ->and($dom->filter('meta[property="og:image:alt"]')->count())->toBe(0)
        ->and($dom->filter('meta[name="twitter:image:alt"]')->count())->toBe(0);
});

it('stores a social image description through the editor', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_social_image_alt' => 'Photo of the team']]])
        ->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->getTranslation('seo_social_image_alt', 'en'))->toBe('Photo of the team');
});
