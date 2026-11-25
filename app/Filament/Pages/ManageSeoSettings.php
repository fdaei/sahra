<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\ArticleSchemaType;
use App\Enums\PageSchemaType;
use App\Models\Setting;
use App\Support\SiteSettings;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

final class ManageSeoSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'seo-settings';
    protected static string $view = 'filament.pages.manage-settings';
    public array $data = [];

    private const KEYS = [
        'seo_default_title' => true, 'seo_default_description' => true,
        'seo_organization_name' => true, 'seo_schema_person_name' => true,
        'seo_default_page_schema_type' => false, 'seo_default_article_schema_type' => false,
        'seo_schema_entity_type' => false, 'seo_404_monitor_enabled' => false,
        'seo_autolink_enabled' => false, 'seo_autolink_max_total' => false,
        'slug_auto_redirect' => false, 'slug_auto_redirect_status' => false,
        'google_search_console_verification' => false,
    ];

    public static function canAccess(): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function getNavigationGroup(): ?string { return __('admin.navigation.groups.SEO'); }
    public static function getNavigationLabel(): string { return __('admin.seo.settings'); }
    public function getTitle(): string { return __('admin.seo.settings'); }

    public function mount(): void
    {
        $stored = Setting::query()->whereIn('key', array_keys(self::KEYS))->get()->keyBy('key');
        $data = [];
        foreach (self::KEYS as $key => $translatable) {
            $value = $stored->get($key)?->value;
            if ($translatable) {
                foreach (array_keys(config('locales.supported')) as $locale) {
                    $data[$key][$locale] = is_array($value) ? ($value[$locale] ?? '') : '';
                }
            } else {
                $data[$key] = is_array($value) ? ($value['value'] ?? null) : $value;
            }
        }
        foreach (['seo_default_page_schema_type' => 'WebPage', 'seo_default_article_schema_type' => 'Article',
            'seo_schema_entity_type' => 'Organization', 'seo_404_monitor_enabled' => false,
            'seo_autolink_enabled' => true, 'seo_autolink_max_total' => 5,
            'slug_auto_redirect' => true, 'slug_auto_redirect_status' => '301'] as $key => $default) {
            $data[$key] ??= $default;
        }
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form->statePath('data')->schema([
            Section::make('Search appearance')->schema([
                $this->translations('seo_default_title', 'Default SEO title'),
                $this->translations('seo_default_description', 'Default SEO description', true),
                TextInput::make('google_search_console_verification')->label('Google Search Console verification')->maxLength(200),
            ]),
            Section::make('Schema defaults')->columns(2)->schema([
                Select::make('seo_schema_entity_type')->label('Site represents')->options(['Organization' => __('Organization'), 'Person' => __('Person')])->in(['Organization', 'Person'])->required()->native(false),
                $this->translations('seo_organization_name', 'Organization name'),
                $this->translations('seo_schema_person_name', 'Person name'),
                Select::make('seo_default_page_schema_type')->label('Default page type')->options(PageSchemaType::options())->in(array_keys(PageSchemaType::options()))->required()->native(false),
                Select::make('seo_default_article_schema_type')->label('Default article type')->options(ArticleSchemaType::options())->in(array_keys(ArticleSchemaType::options()))->required()->native(false),
            ]),
            Section::make('Redirects and monitoring')->schema([
                Toggle::make('slug_auto_redirect')->label('Redirect old URLs after a slug change'),
                Select::make('slug_auto_redirect_status')->label('Automatic redirect status')->options(['301' => '301', '302' => '302', '303' => '303', '307' => '307', '308' => '308'])->in(['301', '302', '303', '307', '308'])->required()->native(false),
                Toggle::make('seo_404_monitor_enabled')->label('Record missing public URLs')->helperText('Stores paths without query strings or IP addresses. Entries expire after 30 days when the scheduler runs.'),
            ]),
            Section::make('Automatic internal links')->schema([
                Toggle::make('seo_autolink_enabled')->label('Apply active keyword rules in articles'),
                TextInput::make('seo_autolink_max_total')->label('Maximum links per article')->numeric()->integer()->minValue(1)->maxValue(20)->required(),
            ]),
        ]);
    }

    public function save(): void
    {
        abort_unless(static::canAccess(), 403);
        $state = $this->form->getState();
        DB::transaction(function () use ($state): void {
            foreach (self::KEYS as $key => $translatable) {
                $value = $translatable ? ($state[$key] ?? []) : ['value' => $state[$key] ?? null];
                Setting::updateOrCreate(['key' => $key], ['group' => 'seo', 'value' => $value, 'is_translatable' => $translatable]);
            }
        });
        SiteSettings::flush();
        Notification::make()->success()->title(__('Settings saved'))->send();
    }

    private function translations(string $key, string $label, bool $multiline = false): Tabs
    {
        return Tabs::make($label)->columnSpanFull()->tabs(
            collect(config('locales.supported'))->map(function (array $config, string $locale) use ($key, $label, $multiline): Tabs\Tab {
                $input = $multiline ? Textarea::make("{$key}.{$locale}")->rows(3) : TextInput::make("{$key}.{$locale}");
                return Tabs\Tab::make($config['native'])->schema([$input->label($label)->maxLength($multiline ? 500 : 300)->extraAttributes(['dir' => $config['direction'], 'lang' => $config['html_lang']])]);
            })->values()->all(),
        );
    }
}
