<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
});

it('outputs separate X and Open Graph fields in server HTML', function (): void {
    $media = Media::create(['path' => 'seo/twitter/image.jpg', 'name' => 'image.jpg', 'mime' => 'image/jpeg', 'type' => 'image']);
    $media->setTranslations(['en' => ['alt' => 'X image library alt']]);
    $post = Post::factory()->published()->create(['cover_path' => 'posts/cover.jpg']);
    $post->setTranslations([
        'en' => ['title' => 'Article', 'slug' => 'article', 'seo_social_title' => 'Social title', 'seo_social_description' => 'Social description',
            'seo_social_image' => 'seo/social/share.jpg', 'seo_social_image_alt' => 'Social alt',
            'seo_twitter_title' => 'X title', 'seo_twitter_description' => 'X description',
            'seo_twitter_image' => 'seo/twitter/image.jpg', 'seo_twitter_card' => 'summary'],
        'fa' => ['title' => 'مقاله', 'slug' => 'article-fa', 'seo_social_title' => 'عنوان عمومی'],
    ]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[property="og:title"]')->attr('content'))->toBe('Social title')
        ->and($dom->filter('meta[property="og:image"]')->attr('content'))->toBe('https://seo.example/storage/seo/social/share.jpg')
        ->and($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('Social alt')
        ->and($dom->filter('meta[name="twitter:card"]')->attr('content'))->toBe('summary')
        ->and($dom->filter('meta[name="twitter:title"]')->attr('content'))->toBe('X title')
        ->and($dom->filter('meta[name="twitter:description"]')->attr('content'))->toBe('X description')
        ->and($dom->filter('meta[name="twitter:image"]')->attr('content'))->toBe('https://seo.example/storage/seo/twitter/image.jpg')
        ->and($dom->filter('meta[name="twitter:image:alt"]')->attr('content'))->toBe('X image library alt');
    $fa = new Crawler($this->get('/fa/insights/article-fa')->assertOk()->getContent());
    expect($fa->filter('meta[name="twitter:title"]')->attr('content'))->toBe('عنوان عمومی');
});

it('inherits social fields and never applies one image alt to a different X image', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article', 'seo_social_title' => 'Social title', 'seo_social_image' => 'seo/social/share.jpg', 'seo_social_image_alt' => 'Social alt']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[name="twitter:card"]')->attr('content'))->toBe('summary_large_image')
        ->and($dom->filter('meta[name="twitter:title"]')->attr('content'))->toBe('Social title')
        ->and($dom->filter('meta[name="twitter:image:alt"]')->attr('content'))->toBe('Social alt');
    $post->setTranslations(['en' => ['seo_twitter_image' => 'seo/twitter/unregistered.jpg']]);
    $dom = new Crawler($this->get('/en/insights/article')->assertOk()->getContent());
    expect($dom->filter('meta[name="twitter:image:alt"]')->count())->toBe(0)
        ->and($dom->filter('meta[property="og:image:alt"]')->attr('content'))->toBe('Social alt');
});

it('uses safe automatic card settings for a missing image or invalid stored type', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About', 'seo_twitter_card' => 'summary_large_image']]);
    $dom = new Crawler($this->get('/en/about')->assertOk()->getContent());
    expect($dom->filter('meta[name="twitter:card"]')->attr('content'))->toBe('summary')
        ->and($dom->filter('meta[name="twitter:image"]')->count())->toBe(0);
    $project = Project::factory()->published()->create(['cover_path' => 'projects/cover.jpg']);
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project', 'seo_twitter_card' => 'invalid']]);
    $dom = new Crawler($this->get('/en/work/project')->assertOk()->getContent());
    expect($dom->filter('meta[name="twitter:card"]')->attr('content'))->toBe('summary_large_image');
});

it('saves X fields through the editor and rejects invalid card types', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_twitter_title' => 'X title', 'seo_twitter_card' => 'summary']]])
        ->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->getTranslation('seo_twitter_title', 'en'))->toBe('X title');
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_twitter_card' => 'bad']]])
        ->call('save')->assertHasFormErrors(['translations.en.seo_twitter_card']);
});

it('persists X overrides in page and project editors', function (string $type): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    if ($type === 'page') {
        $record = Page::factory()->create(['key' => 'about']);
        $record->setTranslations(['en' => ['title' => 'About']]);
        $component = \App\Filament\Resources\PageResource\Pages\EditPage::class;
        $translation = ['title' => 'About', 'seo_twitter_title' => 'About on X'];
    } else {
        $record = Project::factory()->published()->create();
        $record->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
        $component = \App\Filament\Resources\ProjectResource\Pages\EditProject::class;
        $translation = ['title' => 'Project', 'slug' => 'project', 'seo_twitter_title' => 'Project on X'];
    }
    Livewire::actingAs($admin)->test($component, ['record' => $record->getKey()])
        ->fillForm(['translations' => ['en' => $translation]])->call('save')->assertHasNoFormErrors();
    expect($record->refresh()->getTranslation('seo_twitter_title', 'en'))->toBe($translation['seo_twitter_title']);
})->with(['page', 'project']);
