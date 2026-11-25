<?php

declare(strict_types=1);

use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

function schemaNodesForSettings(string $html): array
{
    return (new Crawler($html))->filter('script[type="application/ld+json"]')
        ->each(fn ($node) => json_decode($node->text(), true, flags: JSON_THROW_ON_ERROR));
}

it('renders the selected page type and linked website on translated posts', function (): void {
    $post = Post::factory()->published()->create(['seo_page_schema_type' => 'AboutPage', 'seo_schema_type' => 'TechArticle']);
    $post->setTranslations(['en' => ['title' => 'A guide', 'slug' => 'a-guide'], 'fa' => ['title' => 'راهنما', 'slug' => 'fa-guide']]);
    foreach (['/en/insights/a-guide', '/fa/insights/fa-guide'] as $url) {
        $nodes = collect(schemaNodesForSettings($this->get($url)->assertOk()->getContent()));
        $page = $nodes->firstWhere('@type', 'AboutPage');
        expect($page)->not->toBeNull()->and($page['isPartOf']['@id'])->toEndWith('/#website')
            ->and($nodes->firstWhere('@type', 'TechArticle'))->not->toBeNull();
    }
});

it('uses configured defaults and safely falls back for invalid types', function (): void {
    Setting::create(['key' => 'seo_default_page_schema_type', 'group' => 'seo', 'value' => ['value' => 'ContactPage'], 'is_translatable' => false]);
    Setting::create(['key' => 'seo_default_article_schema_type', 'group' => 'seo', 'value' => ['value' => 'Report'], 'is_translatable' => false]);
    $post = Post::factory()->published()->create(['seo_page_schema_type' => null, 'seo_schema_type' => null]);
    $post->setTranslations(['en' => ['title' => 'Test', 'slug' => 'test']]);
    $nodes = collect(schemaNodesForSettings($this->get('/en/insights/test')->assertOk()->getContent()));
    expect($nodes->pluck('@type')->all())->toContain('ContactPage', 'Report');
    $post->update(['seo_page_schema_type' => 'invalid', 'seo_schema_type' => 'invalid']);
    $nodes = collect(schemaNodesForSettings($this->get('/en/insights/test')->assertOk()->getContent()));
    expect($nodes->pluck('@type')->all())->toContain('WebPage', 'Article')->not->toContain('invalid');
});

it('uses the same translated FAQ and how-to content in the page and schema', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => [
        'title' => 'The guide', 'slug' => 'guide',
        'schema_faq_items' => [['question' => 'Which way?', 'answer' => 'This way.']],
        'schema_howto_title' => 'Getting started', 'schema_howto_steps' => [['name' => 'First', 'text' => 'Start here.']],
    ]]);
    $response = $this->get('/en/insights/guide')->assertOk()->assertSee('Which way?')->assertSee('Start here.');
    $nodes = collect(schemaNodesForSettings($response->getContent()));
    $page = $nodes->first(fn ($node) => in_array('FAQPage', (array) ($node['@type'] ?? []), true));
    expect($page['mainEntity'][0]['name'])->toBe('Which way?')
        ->and($page['mainEntity'][0]['acceptedAnswer']['text'])->toBe('This way.')
        ->and($nodes->firstWhere('@type', 'HowTo')['step'][0]['text'])->toBe('Start here.');
});

it('allows valid schema selections in editors and rejects unknown values', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $page = Page::factory()->create();
    $page->setTranslations(['en' => ['title' => 'About']]);
    Livewire::actingAs($admin)->test(EditPage::class, ['record' => $page->getKey()])
        ->fillForm(['seo_page_schema_type' => 'ContactPage'])->call('save')->assertHasNoFormErrors();
    expect($page->refresh()->seo_page_schema_type)->toBe('ContactPage');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['seo_page_schema_type' => 'InvalidSchema'])->call('save')->assertHasFormErrors(['seo_page_schema_type']);
});

it('saves FAQ and how-to blocks in the article editor', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    Livewire::actingAs($admin)->test(EditPost::class, ['record' => $post->getKey()])
        ->fillForm(['translations' => ['en' => [
            'title' => 'Article title', 'slug' => 'title',
            'schema_faq_items' => [['question' => 'Why?', 'answer' => 'Because.']],
            'schema_howto_title' => 'How', 'schema_howto_steps' => [['name' => 'Step', 'text' => 'Do it.']],
        ]]])->call('save')->assertHasNoFormErrors();
    expect($post->refresh()->getTranslation('schema_faq_items')[0]['question'])->toBe('Why?')
        ->and($post->getTranslation('schema_howto_steps')[0]['text'])->toBe('Do it.');
});

it('does not emit a FAQ schema when the home FAQ section is hidden', function (): void {
    $home = Page::factory()->create(['key' => 'home']);
    $home->setTranslations(['en' => ['title' => 'Home']]);
    $faq = \App\Models\Faq::create(['sort_order' => 1, 'is_active' => true]);
    $faq->setTranslations(['en' => ['question' => 'A question?', 'answer' => 'An answer.']]);
    $section = $home->sections()->create(['type' => \App\Enums\SectionType::Faq, 'is_visible' => true, 'sort_order' => 1]);
    $section->setTranslations(['en' => ['title' => 'FAQs']]);
    $nodes = collect(schemaNodesForSettings($this->get('/en')->assertOk()->getContent()));
    $faqNode = $nodes->first(fn ($node) => in_array('FAQPage', (array) ($node['@type'] ?? []), true));
    expect($faqNode['mainEntity'][0]['name'])->toBe('A question?');
    $section->update(['is_visible' => false]);
    $nodes = collect(schemaNodesForSettings($this->get('/en')->assertOk()->getContent()));
    expect($nodes->contains(fn ($node) => in_array('FAQPage', (array) ($node['@type'] ?? []), true)))->toBeFalse();
});

it('can describe the site as a person without creating a broken publisher reference', function (): void {
    Setting::create(['key' => 'seo_schema_entity_type', 'group' => 'seo', 'value' => ['value' => 'Person'], 'is_translatable' => false]);
    Setting::create(['key' => 'seo_schema_person_name', 'group' => 'seo', 'value' => ['en' => 'Site owner'], 'is_translatable' => true]);
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Article title', 'slug' => 'title']]);
    $nodes = collect(schemaNodesForSettings($this->get('/en/insights/title')->assertOk()->getContent()));
    expect($nodes->firstWhere('@type', 'Person')['name'])->toBe('Site owner')
        ->and($nodes->firstWhere('@type', 'WebSite')['publisher']['@id'])->toEndWith('/#person')
        ->and($nodes->firstWhere('@type', 'Article')['publisher']['@id'])->toEndWith('/#person');
});

it('saves schema defaults in site settings', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    Livewire::actingAs($admin)->test(\App\Filament\Pages\ManageSettings::class)
        ->fillForm([
            'seo_default_page_schema_type' => 'AboutPage',
            'seo_default_article_schema_type' => 'ScholarlyArticle',
            'seo_schema_entity_type' => 'Person',
            'seo_schema_person_name' => ['en' => 'A person'],
        ])->call('save')->assertHasNoFormErrors();
    expect(\App\Support\SiteSettings::get('seo_default_page_schema_type'))->toBe('AboutPage')
        ->and(\App\Support\SiteSettings::get('seo_default_article_schema_type'))->toBe('ScholarlyArticle')
        ->and(\App\Support\SiteSettings::get('seo_schema_entity_type'))->toBe('Person');
});

it('uses a selected schema type on project pages', function (): void {
    $project = \App\Models\Project::factory()->published()->create(['seo_page_schema_type' => 'ItemPage']);
    $project->setTranslations(['en' => ['title' => 'A project', 'slug' => 'a-project']]);
    $nodes = collect(schemaNodesForSettings($this->get('/en/work/a-project')->assertOk()->getContent()));
    expect($nodes->pluck('@type')->all())->toContain('ItemPage', 'CreativeWork');
});

it('renders localised schema blocks on pages and matches the published content', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => [
        'title' => 'About', 'schema_faq_items' => [['question' => 'Where?', 'answer' => 'Here.']],
        'schema_howto_title' => 'Getting started', 'schema_howto_steps' => [['name' => 'Start', 'text' => 'Say hello.']],
    ]]);
    $response = $this->get('/en/about')->assertOk()->assertSee('Where?')->assertSee('Say hello.');
    $nodes = collect(schemaNodesForSettings($response->getContent()));
    $faq = $nodes->first(fn ($node) => in_array('FAQPage', (array) ($node['@type'] ?? []), true));
    expect($faq['mainEntity'][0]['name'])->toBe('Where?')
        ->and($nodes->firstWhere('@type', 'HowTo')['step'][0]['text'])->toBe('Say hello.');
});

it('saves page FAQ and how-to blocks in the editor', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $page = Page::factory()->create();
    $page->setTranslations(['en' => ['title' => 'Page title']]);
    Livewire::actingAs($admin)->test(EditPage::class, ['record' => $page->getKey()])
        ->fillForm(['translations' => ['en' => [
            'title' => 'Page title',
            'schema_faq_items' => [['question' => 'Where?', 'answer' => 'Here.']],
            'schema_howto_title' => 'Guide', 'schema_howto_steps' => [['name' => 'Start', 'text' => 'Go.']],
        ]]])->call('save')->assertHasNoFormErrors();
    expect($page->refresh()->getTranslation('schema_faq_items')[0]['question'])->toBe('Where?')
        ->and($page->getTranslation('schema_howto_steps')[0]['text'])->toBe('Go.');
});
