<?php

declare(strict_types=1);

use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Models\Page;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Livewire\Livewire;

beforeEach(function (): void {
    config(['app.url' => 'https://seo.example', 'seo.canonical_origin' => null]);
    $this->seed(RolePermissionSeeder::class);
    $this->admin = User::factory()->create()->assignRole('admin');
});

it('shows and saves localized page search analysis without assuming section-driven pages have no body', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About marketing', 'description' => 'Marketing team']]);
    Livewire::actingAs($this->admin)->test(EditPage::class, ['record' => $page->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'About marketing', 'description' => 'Marketing team', 'seo_focus_keyphrase' => 'marketing']]])
        ->assertSee('https://seo.example/en/about')
        ->assertSee('Focus keyphrase appears in the search title.')
        ->assertDontSee('Add article body content for this language.')
        ->call('save')->assertHasNoFormErrors();
    expect($page->refresh()->getTranslation('seo_focus_keyphrase', 'en'))->toBe('marketing');
    $this->get('/en/about')->assertOk()->assertDontSee('seo_focus_keyphrase');
});

it('previews project URLs and saves the keyphrase', function (): void {
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Brand project', 'slug' => 'brand', 'excerpt' => 'Brand design']]);
    Livewire::actingAs($this->admin)->test(EditProject::class, ['record' => $project->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Brand project', 'slug' => 'brand', 'excerpt' => 'Brand design', 'seo_focus_keyphrase' => 'brand']]])
        ->assertSee('https://seo.example/en/work/brand')
        ->assertSee('Focus keyphrase appears in the search description.')
        ->assertDontSee('Add article body content for this language.')
        ->call('save')->assertHasNoFormErrors();
    expect($project->refresh()->getTranslation('seo_focus_keyphrase', 'en'))->toBe('brand');
    $this->get('/en/work/brand')->assertOk()->assertDontSee('seo_focus_keyphrase');
});

it('validates required localized fields for a keyphrase without creating incomplete translations', function (): void {
    $project = Project::factory()->published()->create();
    $project->setTranslations(['en' => ['title' => 'Brand', 'slug' => 'brand']]);
    Livewire::actingAs($this->admin)->test(EditProject::class, ['record' => $project->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'Brand', 'slug' => 'brand'], 'fa' => ['seo_focus_keyphrase' => 'برند']]])
        ->call('save')->assertHasFormErrors(['translations.fa.title' => 'required', 'translations.fa.slug' => 'required']);
    expect($project->translations()->where('locale', 'fa')->exists())->toBeFalse();
});

it('requires a page title when enabling noindex in an empty language', function (): void {
    $page = Page::factory()->create(['key' => 'about']);
    $page->setTranslations(['en' => ['title' => 'About']]);
    Livewire::actingAs($this->admin)->test(EditPage::class, ['record' => $page->getKey()])
        ->fillForm(['translations' => ['en' => ['title' => 'About'], 'fa' => ['seo_noindex' => true]]])
        ->call('save')->assertHasFormErrors(['translations.fa.title' => 'required']);
    expect($page->translations()->where('locale', 'fa')->exists())->toBeFalse();
});
