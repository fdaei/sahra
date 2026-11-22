<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\PublicationFields;
use App\Filament\Support\TranslatableForm;
use App\Filament\Support\SeoStatusColumn;
use App\Filament\Support\SocialSeoFields;
use App\Filament\Support\AdvancedRobotsFields;
use App\Filament\Support\ContentSeoFields;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Service;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\PageRegistration;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Case studies. Figma: listing 1362:7198, detail 1323:7541.
 *
 * Structured detail blocks (goals, strategy, deliverables, results) are managed
 * through the Sections relation manager, which is shared with PageResource.
 */
final class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Projects';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->required(fn (Get $get): bool => $locale === config('locales.fallback') || TranslatableForm::hasContent($get, $locale))
                    ->maxLength(200)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set) use ($locale): void {
                        $set(
                            "translations.{$locale}.slug",
                            TranslatableForm::slugify($state, $locale),
                        );
                    }),

                TextInput::make("translations.{$locale}.slug")
                    ->label('Slug')
                    ->live(onBlur: true)
                    ->required(fn (Get $get): bool => $locale === config('locales.fallback') || TranslatableForm::hasContent($get, $locale))
                    ->maxLength(200)
                    ->helperText("URL segment for /{$locale}/work/…"),

                TextInput::make("translations.{$locale}.subtitle")
                    ->label('Subtitle')
                    ->maxLength(300),

                Textarea::make("translations.{$locale}.excerpt")
                    ->label('Card description')
                    ->live(onBlur: true)
                    ->rows(2)
                    ->helperText('Shown on the projects listing card.'),

                Textarea::make("translations.{$locale}.challenge")
                    ->label('The Challenge')
                    ->rows(3),

                TagsInput::make("translations.{$locale}.challenge_points")
                    ->label('Challenge bullet points')
                    ->placeholder('Add a point'),

                Textarea::make("translations.{$locale}.results_summary")
                    ->label('Results summary')
                    ->rows(3),

                Section::make('Image alt text')
                    ->description('Describes each image for screen readers and search engines. Left empty, the alt from the Media library is used.')
                    ->columns(2)
                    ->schema([
                        TextInput::make("translations.{$locale}.cover_alt")
                            ->label('Cover image')
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.banner_alt")
                            ->label('Case-study banner')
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.before_alt")
                            ->label('Before image')
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.after_alt")
                            ->label('After image')
                            ->maxLength(300),
                    ]),

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
                        ...ContentSeoFields::make($locale, 'project'),
                        AdvancedRobotsFields::section($locale),
                        SocialSeoFields::section($locale),
                    ]),
            ]),

            Grid::make(3)->schema([
                Section::make('Details')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Select::make('industry_id')
                            ->label('Industry')
                            ->relationship('industry')
                            ->getOptionLabelFromRecordUsing(
                                fn (Project|Industry $record): string => (string) $record->getTranslation('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->native(false),

                        Select::make('services')
                            ->label('Services delivered')
                            ->relationship('services')
                            ->getOptionLabelFromRecordUsing(
                                fn (Service $record): string => (string) $record->getTranslation('title'),
                            )
                            ->multiple()
                            ->preload()
                            ->native(false),

                        TextInput::make('year')
                            ->maxLength(10)
                            ->placeholder('2024'),

                        TextInput::make('instagram_handle')
                            ->label('Instagram')
                            ->prefix('@')
                            ->maxLength(100),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),

                        Toggle::make('is_featured')
                            ->label('Show this project on the home page')
                            ->helperText('Displays this project in the selected projects section on the home page.'),
                    ]),

                Grid::make(1)->columnSpan(1)->schema([
                    PublicationFields::section(),

                    Section::make('Media')
                        ->schema([
                            ImageUpload::make('cover_path', 'Cover (square)', 'project.cover', 'projects'),

                            ImageUpload::make('banner_path', 'Case-study banner', 'project.banner', 'projects'),

                            ImageUpload::make('before_image_path', 'Before', 'project.beforeafter', 'projects'),

                            ImageUpload::make('after_image_path', 'After', 'project.beforeafter', 'projects'),
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(48),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Project $record): string => (string) $record->getTranslation('title'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas(
                            'translations',
                            fn (Builder $q) => $q->where('title', 'like', "%{$search}%"),
                        );
                    })
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('industry')
                    ->label('Industry')
                    ->getStateUsing(fn (Project $record): string => (string) ($record->industry?->getTranslation('name') ?? '—'))
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Shown on home')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),

                SeoStatusColumn::make(),

                Tables\Columns\TextColumn::make('translations_count')
                    ->label('Locales')
                    ->counts('translations')
                    ->badge()
                    ->color(fn (int $state): string => $state >= 3 ? 'success' : 'warning')
                    ->formatStateUsing(fn (int $state): string => "{$state}/3"),
            ])
            ->filters([
                SeoStatusColumn::noindexFilter(),

                Tables\Filters\SelectFilter::make('status')
                    ->options(PublicationStatus::options()),

                Tables\Filters\SelectFilter::make('industry')
                    ->relationship(
                        'industry',
                        'name',
                        fn (Builder $query): Builder => $query->withTranslations()->ordered(),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (Industry $record): string => (string) $record->getTranslation('name'),
                    ),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Shown on home'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return array<int, class-string>
     */
    public static function getRelations(): array
    {
        return [
            RelationManagers\SectionsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['translations', 'industry.translations'])
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
