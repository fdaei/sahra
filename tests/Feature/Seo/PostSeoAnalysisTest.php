<?php

declare(strict_types=1);

use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Post;
use App\Models\User;
use App\Services\Seo\PostSeoAnalysis;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;

it('analyzes the localized article, using title and excerpt as fallbacks', function (): void {
    app()->setLocale('en');
    $results = app(PostSeoAnalysis::class)->analyze([
        'title' => 'Marketing strategy', 'excerpt' => 'A marketing strategy for your business.',
        'content' => '<h2>Marketing strategy</h2><p>Details <a href="/en/about">About us</a></p>',
        'seo_focus_keyphrase' => 'marketing strategy', 'seo_noindex' => true,
    ], true);
    $messages = array_column($results, 'message');
    expect($messages)->toContain('Search title is present (18 characters).', 'Search description is present (39 characters).',
        'The article has subheadings.', 'The article contains links.', 'Focus keyphrase appears in the article body.', 'This language is set to noindex.')
        ->and(collect($results)->contains(fn ($item) => $item['level'] === 'warning'))->toBeFalse();
});

it('reports missing content and handles Persian and Arabic forms of letters', function (): void {
    app()->setLocale('en');
    $service = app(PostSeoAnalysis::class);
    $messages = array_column($service->analyze(['title' => 'بازاریابی دیجیتال', 'excerpt' => 'بازاريابي ديجيتال', 'content' => '<p>بازاریابی دیجیتال</p>', 'seo_focus_keyphrase' => 'بازاريابي ديجيتال'], false), 'message');
    expect($messages)->toContain('Focus keyphrase appears in the search title.', 'Focus keyphrase appears in the search description.', 'Focus keyphrase appears in the article body.');
    $empty = array_column($service->analyze([], false), 'message');
    expect($empty)->toContain('Add a title for the search result.', 'Add an SEO description or a summary for this language.', 'Add article body content for this language.');
});

it('updates and saves keyphrase checks through the real editor without publishing the keyphrase', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'An article', 'slug' => 'article', 'excerpt' => 'A summary', 'content' => '<p>Some text</p>']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'An article', 'slug' => 'article', 'excerpt' => 'A summary', 'content' => '<p>Some text</p>', 'seo_focus_keyphrase' => 'article']]])
        ->assertSee('Focus keyphrase appears in the search title.')
        ->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->getTranslation('seo_focus_keyphrase', 'en'))->toBe('article');
    $this->get('/en/insights/article')->assertOk()->assertDontSee('name="keywords"', false)->assertDontSee('seo_focus_keyphrase');
});

it('previews the search result using the effective localized values and safely displays authored text', function (): void {
    $service = app(PostSeoAnalysis::class);
    $preview = $service->preview(['title' => 'Fallback title', 'slug' => 'sample', 'excerpt' => '<b>Description</b>'], 'en');
    expect($preview['title'])->toBe('Fallback title')->and($preview['description'])->toBe('Description')
        ->and($preview['url'])->toEndWith('/en/insights/sample');
    $canonical = $service->preview(['seo_canonical_url' => 'https://example.com/preferred', 'slug' => 'sample'], 'en');
    expect($canonical['url'])->toBe('https://example.com/preferred');
    $rendered = view('filament.components.post-seo-analysis', ['checks' => [['level' => 'info', 'message' => '<script>bad</script>']], 'preview' => ['title' => '<script>bad</script>', 'description' => '', 'url' => '']])->render();
    expect($rendered)->not->toContain('<script>bad</script>')->toContain('&lt;script&gt;bad&lt;/script&gt;');
});

it('requires a title and slug before saving a keyphrase in an optional language', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getRouteKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Article', 'slug' => 'article'], 'fa' => ['seo_focus_keyphrase' => 'کلید']]])
        ->call('save')->assertHasFormErrors(['translations.fa.title' => 'required', 'translations.fa.slug' => 'required']);
    expect($post->translations()->where('locale', 'fa')->exists())->toBeFalse();
});
