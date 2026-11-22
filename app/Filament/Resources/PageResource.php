<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers\SectionsRelationManager;
use App\Filament\Support\PublicationFields;
use App\Filament\Support\TranslatableForm;
use App\Filament\Support\SeoStatusColumn;
use App\Filament\Support\SocialSeoFields;
use App\Filament\Support\AdvancedRobotsFields;
use App\Filament\Support\ContentSeoFields;
use App\Models\Page;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\PageRegistration;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Editable pages, resolved by `key`.
 *
 * The key is immutable after creation — routes and controllers resolve by it,
 * so letting an editor change it would silently 404 a live page.
 */
final class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Website content';

    protected static ?string $navigationLabel = 'Main pages';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('key')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit')
                        ->helperText('Immutable identifier used by routing, e.g. "home".'),
                ]),

            PublicationFields::section(),

            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->live(onBlur: true)
                    ->required(fn (Get $get): bool => $locale === config('locales.fallback') || TranslatableForm::hasContent($get, $locale))
                    ->maxLength(200),

                TextInput::make("translations.{$locale}.subtitle")
                    ->label('Eyebrow / subtitle')
                    ->maxLength(300),

                Textarea::make("translations.{$locale}.description")
                    ->label('Intro description')
                    ->live(onBlur: true)
                    ->rows(3),

                RichEditor::make("translations.{$locale}.content")
                    ->label('Body content')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 'bulletList', 'orderedList',
                        'h2', 'h3', 'blockquote', 'undo', 'redo',
                    ])
                    ->helperText('Used by legal pages. Leave empty for section-driven pages.'),

                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make("translations.{$locale}.seo_title")
                            ->label('SEO title')
                            ->live(onBlur: true)
                            ->maxLength(200),
                        Textarea::make("translations.{$locale}.seo_description")
                            ->label('SEO description')
                            ->live(onBlur: true)
                            ->rows(2)
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.seo_canonical_url")
                            ->label('Canonical URL')
                            ->live(onBlur: true)
                            ->helperText('Optional absolute HTTP or HTTPS URL of the preferred version. Leave empty to use this page’s own URL.')
                            ->maxLength(2048)
                            ->rules(['nullable', new \App\Rules\CanonicalUrlRule]),
                        Toggle::make("translations.{$locale}.seo_noindex")
                            ->label('Hide this language from search engines')
                            ->live()
                            ->helperText('Adds noindex and removes this language from the sitemap and hreflang links.')
                            ->default(false),
                        Toggle::make("translations.{$locale}.seo_nofollow")
                            ->label('Ask search engines not to follow links')
                            ->helperText('Adds nofollow for this language.')
                            ->default(false),
                        ...ContentSeoFields::make($locale, 'page'),
                        AdvancedRobotsFields::section($locale),
                        SocialSeoFields::section($locale),
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Page $record): string => (string) $record->getTranslation('title'))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('sections_count')
                    ->label('Sections')
                    ->counts('sections')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                SeoStatusColumn::make(),

                Tables\Columns\TextColumn::make('translations_count')
                    ->label('Locales')
                    ->counts('translations')
                    ->badge()
                    ->color(fn (int $state): string => $state >= 3 ? 'success' : 'warning')
                    ->formatStateUsing(fn (int $state): string => "{$state}/3"),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SeoStatusColumn::noindexFilter(),

                Tables\Filters\SelectFilter::make('status')
                    ->options(PublicationStatus::options()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    /**
     * @return array<int, class-string>
     */
    public static function getRelations(): array
    {
        return [
            SectionsRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }
}
