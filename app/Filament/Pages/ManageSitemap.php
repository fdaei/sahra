<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Support\SitemapOptions;
use App\Support\SiteSettings;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

final class ManageSitemap extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'sitemap';
    protected static string $view = 'filament.pages.manage-settings';
    public array $data = [];

    public static function canAccess(): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function getNavigationGroup(): ?string { return __('admin.navigation.groups.SEO'); }
    public static function getNavigationLabel(): string { return __('admin.seo.sitemap'); }
    public function getTitle(): string { return __('admin.seo.sitemap'); }

    public function mount(): void
    {
        foreach (['pages', 'posts', 'projects', 'images'] as $type) $this->data[$type] = SitemapOptions::enabled($type);
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form->statePath('data')->schema([
            Section::make('Sitemap contents')
                ->description('Only published, indexable content with a self-canonical URL is included.')
                ->schema([
                    Toggle::make('pages')->label('Main pages'),
                    Toggle::make('posts')->label('Articles'),
                    Toggle::make('projects')->label('Projects'),
                    Toggle::make('images')->label('Images')->helperText('Includes accessible images unless image indexing is disabled for that content.'),
                ]),
        ]);
    }

    public function save(): void
    {
        abort_unless(static::canAccess(), 403);
        $state = $this->form->getState();
        DB::transaction(function () use ($state): void {
            foreach (['pages', 'posts', 'projects', 'images'] as $type) {
                Setting::updateOrCreate(['key' => 'sitemap_'.$type], ['group' => 'seo', 'value' => ['value' => (bool) $state[$type]], 'is_translatable' => false]);
            }
        });
        SiteSettings::flush();
        Notification::make()->success()->title(__('Settings saved'))->send();
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('view')->label(__('View sitemap'))->icon('heroicon-o-arrow-top-right-on-square')->url(route('sitemap'), shouldOpenInNewTab: true)];
    }
}
