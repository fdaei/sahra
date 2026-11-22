<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Support\TranslatableForm;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

function robotsContent(string $html): string
{
    return (new Crawler($html))->filter('meta[name="robots"]')->attr('content');
}

it('renders advanced directives in server HTML and inertia without changing other languages', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations([
        'en' => ['title' => 'Article', 'slug' => 'article', 'seo_nosnippet' => true, 'seo_noimageindex' => true, 'seo_max_image_preview' => 'none', 'seo_max_snippet' => 25, 'seo_max_video_preview' => 10],
        'fa' => ['title' => 'مقاله', 'slug' => 'article-fa'],
    ]);
    $expected = 'index, follow, nosnippet, noimageindex, max-image-preview:none';
    expect(robotsContent($this->get('/en/insights/article')->assertOk()->getContent()))->toBe($expected)
        ->and(robotsContent($this->get('/fa/insights/article-fa')->assertOk()->getContent()))->toBe('index, follow, max-image-preview:large');
    $this->get('/en/insights/article')->assertInertia(fn (Assert $page) => $page->where('seo.robots', $expected));
    $this->get('/sitemap-en.xml')->assertOk()->assertSee('/en/insights/article');
});

it('supports numeric limits including zero and minus one on pages and projects', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About', 'seo_max_snippet' => 0, 'seo_max_video_preview' => -1, 'seo_max_image_preview' => 'standard']]);
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project', 'seo_noindex' => true, 'seo_nofollow' => true, 'seo_max_snippet' => 40]]);
    expect(robotsContent($this->get('/en/about')->assertOk()->getContent()))->toBe('index, follow, max-image-preview:standard, max-snippet:0, max-video-preview:-1')
        ->and(robotsContent($this->get('/en/work/project')->assertOk()->getContent()))->toBe('noindex, nofollow, max-snippet:40');
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/work/project');
});

it('ignores invalid values already stored and preserves existing defaults', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article', 'seo_max_image_preview' => 'invalid', 'seo_max_snippet' => -2, 'seo_max_video_preview' => -2]]);
    expect(robotsContent($this->get('/en/insights/article')->assertOk()->getContent()))->toBe('index, follow, max-image-preview:large');
});

it('saves directives from the editor and validates limits and choices', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_max_image_preview' => 'standard', 'seo_max_snippet' => 0, 'seo_noimageindex' => true]]])
        ->call('save')->assertHasNoFormErrors();
    $post->refresh();
    expect($post->getTranslation('seo_max_image_preview', 'en'))->toBe('standard')
        ->and((int) $post->getTranslation('seo_max_snippet', 'en'))->toBe(0)
        ->and((bool) $post->getTranslation('seo_noimageindex', 'en'))->toBeTrue();
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article', 'seo_max_snippet' => -2, 'seo_max_image_preview' => 'invalid']]])
        ->call('save')->assertHasFormErrors(['translations.en.seo_max_snippet', 'translations.en.seo_max_image_preview']);
});

it('does not persist untouched boolean controls in empty languages', function (): void {
    $post = Post::factory()->create();
    TranslatableForm::persist($post, [
        'en' => ['title' => 'Article', 'slug' => 'article'],
        'fa' => ['title' => null, 'slug' => null, 'seo_noindex' => false, 'seo_nofollow' => false, 'seo_nosnippet' => false, 'seo_noimageindex' => false],
    ]);
    expect($post->translations()->count())->toBe(1);
});

it('persists advanced controls through page and project editors', function (string $type): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    if ($type === 'page') {
        $record = Page::factory()->create(['key' => 'about']);
        $record->setTranslations(['en' => ['title' => 'About']]);
        $component = \App\Filament\Resources\PageResource\Pages\EditPage::class;
        $translation = ['title' => 'About', 'seo_nosnippet' => true, 'seo_max_video_preview' => -1];
    } else {
        $record = Project::factory()->published()->create();
        $record->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
        $component = \App\Filament\Resources\ProjectResource\Pages\EditProject::class;
        $translation = ['title' => 'Project', 'slug' => 'project', 'seo_nosnippet' => true, 'seo_max_video_preview' => -1];
    }
    Livewire::actingAs($admin)->test($component, ['record' => $record->getKey()])
        ->fillForm(['translations' => ['en' => $translation]])->call('save')->assertHasNoFormErrors();
    $record->refresh();
    expect((bool) $record->getTranslation('seo_nosnippet', 'en'))->toBeTrue()
        ->and((int) $record->getTranslation('seo_max_video_preview', 'en'))->toBe(-1);
})->with(['page', 'project']);
