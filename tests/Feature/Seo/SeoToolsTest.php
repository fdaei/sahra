<?php

declare(strict_types=1);

use App\Filament\Pages\ManageSeoSettings;
use App\Filament\Pages\ManageSitemap;
use App\Filament\Resources\InternalLinkResource\Pages\CreateInternalLink;
use App\Models\InternalLink;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('links matching article text without changing content, links or headings', function (): void {
    $post = Post::factory()->published()->create();
    $content = '<h2>Digital marketing</h2><p>Digital marketing helps. Digital marketing matters.</p><p><a href="/en/contact">Digital marketing</a></p>';
    $post->setTranslations(['en' => ['title' => 'Test', 'slug' => 'test', 'content' => $content]]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'digital marketing', 'url' => '/en/services', 'max_per_page' => 1, 'is_active' => true]);
    InternalLink::create(['locale' => 'fa', 'keyword' => 'digital marketing', 'url' => '/fa/services', 'max_per_page' => 2, 'is_active' => true]);
    $response = $this->get('/en/insights/test')->assertOk();
    $html = $response->getContent();
    expect(substr_count($html, 'href="/en/services" class="auto-link"'))->toBe(1)
        ->and($html)->toContain('<h2>Digital marketing</h2>')
        ->and($post->refresh()->getTranslation('content'))->toBe($content);
});

it('does not link to the article itself or apply disabled rules', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Test', 'slug' => 'test', 'content' => '<p>Marketing and growth</p>']]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'Marketing', 'url' => '/en/insights/test', 'max_per_page' => 1, 'is_active' => true]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'growth', 'url' => '/en/services', 'max_per_page' => 1, 'is_active' => false]);
    $this->get('/en/insights/test')->assertOk()->assertDontSee('class="auto-link"', false);
});

it('rejects unsafe internal link paths in the editor', function (string $path): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    Livewire::actingAs($admin)->test(CreateInternalLink::class)
        ->fillForm(['locale' => 'en', 'keyword' => 'keyword', 'url' => $path, 'max_per_page' => 1, 'is_active' => true])
        ->call('create')->assertHasFormErrors(['url']);
    expect(InternalLink::count())->toBe(0);
})->with(['https://outside.test', '//outside.test', '/\\outside.test', 'javascript:alert(1)']);

it('disables automatic article links from SEO settings', function (): void {
    Setting::create(['key' => 'seo_autolink_enabled', 'group' => 'seo', 'value' => ['value' => false], 'is_translatable' => false]);
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Test', 'slug' => 'test', 'content' => '<p>Marketing</p>']]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'Marketing', 'url' => '/en/services', 'max_per_page' => 1, 'is_active' => true]);
    $this->get('/en/insights/test')->assertOk()->assertDontSee('class="auto-link"', false);
});

it('controls which kinds of content and images are present in the sitemap', function (): void {
    Storage::fake('public'); Storage::disk('public')->put('cover.jpg', 'test');
    $page = Page::factory()->create(['key' => 'about']); $page->setTranslations(['en' => ['title' => 'About']]);
    $post = Post::factory()->published()->create(['cover_path' => 'cover.jpg']); $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    $project = Project::factory()->published()->create(); $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    $this->get('/sitemap-en.xml')->assertOk()->assertSee('/en/about', false)->assertSee('/en/insights/article', false)->assertSee('/en/work/project', false)->assertSee('<image:image>', false);
    foreach (['pages', 'posts', 'images'] as $type) Setting::create(['key' => 'sitemap_'.$type, 'group' => 'seo', 'value' => ['value' => false], 'is_translatable' => false]);
    $this->get('/sitemap-en.xml')->assertOk()->assertDontSee('/en/about', false)->assertDontSee('/en/insights/article', false)->assertSee('/en/work/project', false)->assertDontSee('<image:image>', false);
});

it('shows the SEO tools to admins and denies them to guests', function (): void {
    foreach (['/admin/seo-settings', '/admin/sitemap', '/admin/seo-guide', '/admin/internal-links'] as $url) $this->get($url)->assertRedirect();
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    foreach (['/admin/seo-settings', '/admin/sitemap', '/admin/seo-guide', '/admin/internal-links'] as $url) $this->actingAs($admin)->get($url)->assertOk();
});

it('saves sitemap and SEO settings separately without overwriting unrelated settings', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    Setting::create(['key' => 'contact_phone', 'group' => 'general', 'value' => ['value' => '123'], 'is_translatable' => false]);
    Livewire::actingAs($admin)->test(ManageSitemap::class)->fillForm(['pages' => false, 'posts' => true, 'projects' => true, 'images' => false])->call('save')->assertHasNoFormErrors();
    Livewire::actingAs($admin)->test(ManageSeoSettings::class)->fillForm(['seo_autolink_enabled' => false, 'seo_autolink_max_total' => 3])->call('save')->assertHasNoFormErrors();
    expect(\App\Support\SiteSettings::get('sitemap_pages'))->toBeFalse()
        ->and(\App\Support\SiteSettings::get('seo_autolink_enabled'))->toBeFalse()
        ->and(\App\Support\SiteSettings::get('contact_phone'))->toBe('123');
});

it('matches Persian variants and respects the total link limit', function (): void {
    $fragment = new \App\Services\Content\HtmlFragment('<p>بهینه سازی سایت مهم است. بهینه‌سازی سايت را جدی بگیرید. SEO Tips و seo tips</p>');
    $count = \App\Services\Content\AutoLinker::apply($fragment, [
        ['keyword' => 'بهینه‌سازی سایت', 'url' => '/fa/services/seo', 'max' => 2],
        ['keyword' => 'seo tips', 'url' => '/fa/insights/tips', 'max' => 1],
    ], null, 2);
    expect($count)->toBe(2)->and(substr_count($fragment->html(), 'href="/fa/services/seo"'))->toBe(2)
        ->and($fragment->html())->not->toContain('href="/fa/insights/tips"');
});

it('does not advertise or serve disabled sitemap shards', function (): void {
    config()->set('seo.sitemap_chunk_size', 1);
    $post = Post::factory()->published()->create(); $post->setTranslations(['en' => ['title' => 'Article', 'slug' => 'article']]);
    $project = Project::factory()->published()->create(); $project->setTranslations(['en' => ['title' => 'Project', 'slug' => 'project']]);
    Setting::create(['key' => 'sitemap_posts', 'group' => 'seo', 'value' => ['value' => false], 'is_translatable' => false]);
    $this->get('/sitemap.xml')->assertOk()->assertDontSee('sitemap-en-post-', false)->assertSee('sitemap-en-project-', false);
    $this->get('/sitemap-en-post-1.xml')->assertNotFound();
    $this->get('/sitemap-en-project-1.xml')->assertOk()->assertSee('/en/work/project', false);
});

it('applies the SEO settings to the live automatic linker', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Test', 'slug' => 'test', 'content' => '<p>SEO and branding.</p>']]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'SEO', 'url' => '/en/services', 'max_per_page' => 1, 'is_active' => true]);
    InternalLink::create(['locale' => 'en', 'keyword' => 'branding', 'url' => '/en/about', 'max_per_page' => 1, 'is_active' => true]);
    Livewire::actingAs($admin)->test(ManageSeoSettings::class)->fillForm(['seo_autolink_enabled' => true, 'seo_autolink_max_total' => 1])->call('save')->assertHasNoFormErrors();
    $html = $this->get('/en/insights/test')->assertOk()->getContent();
    expect(substr_count($html, 'class="auto-link"'))->toBe(1);
});

it('supports regex redirects, capture groups, and gone responses without affecting admin routes', function (): void {
    \App\Models\Redirect::create(['source_path' => 'en/old/(.*)', 'destination_path' => 'en/new/$1', 'status_code' => 301, 'match_type' => 'regex', 'is_active' => true]);
    \App\Models\Redirect::create(['source_path' => 'en/removed', 'destination_path' => null, 'status_code' => 410, 'match_type' => 'exact', 'is_active' => true]);
    $this->get('/en/old/example')->assertRedirect('/en/new/example');
    $this->get('/en/removed')->assertStatus(410);
    expect(\App\Models\Redirect::where('source_path', 'en/removed')->value('hits'))->toBe(1);
});

it('ignores regex redirects that resolve to unsafe external targets', function (): void {
    \App\Models\Redirect::create(['source_path' => 'en/old/(.*)', 'destination_path' => '//evil.test/$1', 'status_code' => 302, 'match_type' => 'regex', 'is_active' => true]);
    $response = $this->get('/en/old/example');
    expect(parse_url((string) $response->headers->get('Location'), PHP_URL_HOST))->not->toBe('evil.test');
});

it('creates regex and gone redirect rules from the panel', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    Livewire::actingAs($admin)->test(\App\Filament\Resources\RedirectResource\Pages\CreateRedirect::class)
        ->fillForm(['match_type' => 'regex', 'source_path' => 'en/legacy/(.*)', 'destination_path' => 'en/new/$1', 'status_code' => 301, 'is_active' => true])
        ->call('create')->assertHasNoFormErrors();
    $this->get('/en/legacy/hello')->assertRedirect('/en/new/hello');
    Livewire::actingAs($admin)->test(\App\Filament\Resources\RedirectResource\Pages\CreateRedirect::class)
        ->fillForm(['match_type' => 'exact', 'source_path' => 'en/removed', 'status_code' => 410, 'is_active' => true])
        ->call('create')->assertHasNoFormErrors();
    $this->get('/en/removed')->assertStatus(410);
});

it('imports CSV safely and skips existing rules unless updating is selected', function (): void {
    $path = tempnam(sys_get_temp_dir(), 'redirect-csv-');
    file_put_contents($path, "source,destination,status,match_type,active\nen/old,en/new,301,exact,1\nen/removed,,410,exact,1\nen/bad,javascript:alert(1),302,exact,1\n");
    try {
        $result = \App\Services\Redirects\RedirectCsv::import($path);
        expect($result)->toBe(['created' => 2, 'updated' => 0, 'skipped' => 1]);
        $this->get('/en/old')->assertRedirect('/en/new');
        $this->get('/en/removed')->assertStatus(410);
        expect(\App\Services\Redirects\RedirectCsv::import($path))->toBe(['created' => 0, 'updated' => 0, 'skipped' => 3]);
        expect(\App\Services\Redirects\RedirectCsv::import($path, true))->toBe(['created' => 0, 'updated' => 2, 'skipped' => 1]);
    } finally { unlink($path); }
});

it('records bot and human 404 reports separately without retaining referrer paths or queries', function (): void {
    Setting::create(['key' => 'seo_404_monitor_enabled', 'group' => 'seo', 'value' => ['value' => true], 'is_translatable' => false]);
    $this->withHeaders(['User-Agent' => 'Mozilla/5.0', 'Referer' => 'https://example.org/private?token=secret'])->get('/en/not-a-real-page')->assertNotFound();
    $this->withHeaders(['User-Agent' => 'ExampleCrawler', 'Referer' => 'https://example.org/another?token=secret'])->get('/en/not-a-real-page')->assertNotFound();
    $rows = \App\Models\NotFoundVisit::where('path', 'en/not-a-real-page')->orderBy('is_bot')->get();
    expect($rows)->toHaveCount(2)->and($rows[0]->is_bot)->toBeFalse()->and($rows[1]->is_bot)->toBeTrue()
        ->and($rows[0]->referrer_host)->toBe('example.org')->and($rows[1]->referrer_host)->toBe('example.org');
});

it('does not issue redirects when regex rules would form a loop', function (): void {
    \App\Models\Redirect::create(['source_path' => 'en/old/(.*)', 'destination_path' => 'en/new/$1', 'status_code' => 301, 'match_type' => 'regex', 'is_active' => true]);
    \App\Models\Redirect::create(['source_path' => 'en/new/(.*)', 'destination_path' => 'en/old/$1', 'status_code' => 301, 'match_type' => 'regex', 'is_active' => true]);
    $this->get('/en/old/test')->assertNotFound();
});

it('accepts delimited regex rules from imported redirect data', function (): void {
    \App\Models\Redirect::create(['source_path' => '#^en/legacy/(.*)$#u', 'destination_path' => 'en/new/$1', 'status_code' => 301, 'match_type' => 'regex', 'is_active' => true]);
    $this->get('/en/legacy/example')->assertRedirect('/en/new/example');
});

it('keeps the 404 monitor alias compatible with the SEO menu URL', function (): void {
    $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    $admin = \App\Models\User::factory()->create()->assignRole('admin');
    $this->actingAs($admin)->get('/admin/not-found-logs')->assertRedirect('/admin/not-found-visits');
});
