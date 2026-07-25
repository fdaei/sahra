<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Support\SiteSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

/**
 * Site-wide settings: brand details, contact info and SEO defaults.
 *
 * Backed by the key/value `settings` table. Translatable values are stored as
 * {"en":…,"fa":…,"ar":…} — the one documented JSON exception (see the
 * settings migration header).
 *
 * Figma sources: footer 1419:9317, contact details card 1363:8934.
 */
final class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Site';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Site settings';

    protected static string $view = 'filament.pages.manage-settings';

    /** @var array<string, mixed> */
    public array $data = [];

    /**
     * key => translatable?
     *
     * @var array<string, bool>
     */
    private const KEYS = [
        'site_name' => true,
        'tagline' => true,
        'footer_description' => true,
        'contact_whatsapp' => false,
        'contact_phone' => false,
        'contact_email' => false,
        'contact_location' => true,
        'contact_working_with' => true,
        'seo_default_title' => true,
        'seo_default_description' => true,
        'seo_default_image' => false,
        'seo_organization_name' => true,
    ];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $stored = Setting::query()->get()->keyBy('key');

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

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('Brand')
                    ->schema([
                        $this->translatableInput('site_name', 'Site name'),
                        $this->translatableInput('tagline', 'Tagline'),
                        $this->translatableTextarea('footer_description', 'Footer description'),
                    ]),

                Section::make('Contact details')
                    ->description('Rendered in the footer and on the contact page.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_whatsapp')
                            ->label('WhatsApp number')
                            ->maxLength(50),

                        TextInput::make('contact_phone')
                            ->label('Phone number')
                            ->maxLength(50),

                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(200),

                        $this->translatableInput('contact_location', 'Location')
                            ->columnSpanFull(),

                        $this->translatableInput('contact_working_with', 'Working with')
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO defaults')
                    ->description('Used when a page has no specific SEO values.')
                    ->schema([
                        $this->translatableInput('seo_default_title', 'Default title'),
                        $this->translatableTextarea('seo_default_description', 'Default description'),
                        $this->translatableInput('seo_organization_name', 'Organisation name'),

                        FileUpload::make('seo_default_image')
                            ->label('Default share image')
                            ->image()
                            ->directory('seo')
                            ->disk('public')
                            ->maxSize(4096)
                            ->helperText('Shown when a page has no image. 1200×630 recommended.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        DB::transaction(function () use ($state): void {
            foreach (self::KEYS as $key => $translatable) {
                $value = $translatable
                    ? ($state[$key] ?? [])
                    : ['value' => $state[$key] ?? null];

                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'group' => str_contains($key, 'seo_') ? 'seo' : 'general',
                        'value' => $value,
                        'is_translatable' => $translatable,
                    ],
                );
            }
        });

        SiteSettings::flush();

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->send();
    }

    /**
     * @return array<int, \Filament\Actions\Action>
     */
    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Save changes')
                ->submit('save'),
        ];
    }

    private function translatableInput(string $key, string $label): Tabs
    {
        return Tabs::make($label)
            ->columnSpanFull()
            ->tabs(
                collect(config('locales.supported'))
                    ->map(fn (array $config, string $locale): Tabs\Tab => Tabs\Tab::make($config['native'])
                        ->schema([
                            TextInput::make("{$key}.{$locale}")
                                ->label($label)
                                ->maxLength(300)
                                ->extraAttributes([
                                    'dir' => $config['direction'],
                                    'lang' => $config['html_lang'],
                                ]),
                        ]))
                    ->values()
                    ->all(),
            );
    }

    private function translatableTextarea(string $key, string $label): Tabs
    {
        return Tabs::make($label)
            ->columnSpanFull()
            ->tabs(
                collect(config('locales.supported'))
                    ->map(fn (array $config, string $locale): Tabs\Tab => Tabs\Tab::make($config['native'])
                        ->schema([
                            Textarea::make("{$key}.{$locale}")
                                ->label($label)
                                ->rows(3)
                                ->maxLength(500)
                                ->extraAttributes([
                                    'dir' => $config['direction'],
                                    'lang' => $config['html_lang'],
                                ]),
                        ]))
                    ->values()
                    ->all(),
            );
    }
}
