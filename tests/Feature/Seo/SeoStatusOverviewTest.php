<?php

declare(strict_types=1);

use App\Filament\Resources\PageResource\Pages\ListPages;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use App\Services\Seo\ContentSeoStatus;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
    app()->setLocale('en');
});

it('reports saved metadata and explicit indexing choices in the requested language', function (): void {
    $post = Post::factory()->published()->create();
    $post->setTranslations(['en' => ['title' => 'Post', 'slug' => 'post'], 'fa' => ['title' => 'نوشته', 'slug' => 'post-fa', 'seo_noindex' => true]]);
    expect(ContentSeoStatus::for($post, 'en'))->toBe('missing_description')
        ->and(ContentSeoStatus::for($post, 'fa'))->toBe('noindex')
        ->and(ContentSeoStatus::for($post, 'ar'))->toBe('missing_translation');
    $post->setTranslations(['en' => ['seo_description' => 'A description']]);
    expect(ContentSeoStatus::for($post, 'en'))->toBe('metadata_present');
    $post->setTranslations(['en' => ['seo_canonical_url' => 'https://other.example/alternative']]);
    expect(ContentSeoStatus::for($post, 'en'))->toBe('canonical_elsewhere');
});

it('handles pages, projects, and site-wide description defaults', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About', 'description' => 'About us']]);
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Work', 'slug' => 'work', 'excerpt' => 'Project overview']]);
    expect(ContentSeoStatus::for($page, 'en'))->toBe('metadata_present')
        ->and(ContentSeoStatus::for($project, 'en'))->toBe('metadata_present');
    $project->setTranslations(['en' => ['excerpt' => null]]);
    \App\Models\Setting::updateOrCreate(['key' => 'seo_default_description'], ['value' => ['en' => 'Default description'], 'group' => 'seo']);
    expect(ContentSeoStatus::for($project, 'en'))->toBe('metadata_present');
});

it('shows the status column and filters noindex in each content list', function (string $type): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    [$first, $second, $component] = match ($type) {
        'page' => [Page::factory()->create(['key' => 'about']), Page::factory()->create(['key' => 'contact']), ListPages::class],
        'project' => [Project::factory()->published()->create(), Project::factory()->published()->create(), ListProjects::class],
        default => [Post::factory()->published()->create(), Post::factory()->published()->create(), ListPosts::class],
    };
    $first->setTranslations(['en' => ['title' => 'Hidden from search', 'slug' => 'first', 'seo_noindex' => true]]);
    $second->setTranslations(['en' => ['title' => 'Visible to search', 'slug' => 'second', 'seo_noindex' => false]]);
    Livewire::actingAs($admin)->test($component)
        ->assertTableColumnExists('seo_status')
        ->assertTableColumnStateSet('seo_status', 'noindex', $first)
        ->assertCanSeeTableRecords([$first, $second])
        ->filterTable('seo_noindex')
        ->assertCanSeeTableRecords([$first])
        ->assertCanNotSeeTableRecords([$second]);
})->with(['page', 'project', 'post']);
