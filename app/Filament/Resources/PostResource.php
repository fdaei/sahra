<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resource;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\LeadMagnetDeliveriesRelationManager;
use App\Filament\Support\PublicationFields;
use App\Filament\Support\SvgIconUpload;
use App\Filament\Support\TranslatableForm;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Blog articles. Figma: listing 1353:7935, detail 1352:7391.
 */
final class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Articles';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(250)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set) use ($locale): void {
                        $set(
                            "translations.{$locale}.slug",
                            TranslatableForm::slugify($state, $locale),
                        );
                    }),

                TextInput::make("translations.{$locale}.slug")
                    ->label('Slug')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(250),

                TextInput::make("translations.{$locale}.subtitle")
                    ->label('Subtitle')
                    ->maxLength(300),

                Textarea::make("translations.{$locale}.excerpt")
                    ->label('Excerpt')
                    ->rows(3)
                    ->helperText('Shown on listing cards and used as the SEO description fallback.'),

                RichEditor::make("translations.{$locale}.content")
                    ->label('Article body')
                    ->helperText('Insert [[lead_magnet]] on its own line wherever this article’s download banner should appear.')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 'bulletList', 'orderedList',
                        'h2', 'h3', 'blockquote', 'codeBlock', 'undo', 'redo',
                    ]),

                Section::make('Article download banner')
                    ->description('Localised copy for the [[lead_magnet]] block. The downloadable file is selected below.')
                    ->collapsed()
                    ->schema([
                        TextInput::make("translations.{$locale}.lead_magnet_title")
                            ->label('Title')
                            ->maxLength(250),
                        Textarea::make("translations.{$locale}.lead_magnet_description")
                            ->label('Description')
                            ->rows(2),
                        TextInput::make("translations.{$locale}.lead_magnet_cta_label")
                            ->label('Button label')
                            ->maxLength(100),
                        TextInput::make("translations.{$locale}.lead_magnet_image_alt")
                            ->label('Background image alt text')
                            ->maxLength(300),
                    ]),

                TextInput::make("translations.{$locale}.cover_alt")
                    ->label('Cover alt text')
                    ->maxLength(300),

                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make("translations.{$locale}.seo_title")
                            ->label('SEO title')
                            ->maxLength(200),
                        Textarea::make("translations.{$locale}.seo_description")
                            ->label('SEO description')
                            ->rows(2)
                            ->maxLength(300),
                    ]),
            ]),

            Grid::make(3)->schema([
                Section::make('Details')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Select::make('post_category_id')
                            ->label('Category')
                            ->relationship('category')
                            ->getOptionLabelFromRecordUsing(
                                fn (PostCategory $record): string => (string) $record->getTranslation('name'),
                            )
                            ->searchable()
                            ->preload()
                            ->native(false),

                        Select::make('tags')
                            ->relationship('tags')
                            ->getOptionLabelFromRecordUsing(
                                fn (PostTag $record): string => (string) $record->getTranslation('name'),
                            )
                            ->multiple()
                            ->preload()
                            ->native(false),

                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->native(false),

                        TextInput::make('reading_minutes')
                            ->label('Reading time (minutes)')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->helperText('Recalculated automatically on save.'),

                        Toggle::make('is_featured')
                            ->label('Show as the main article')
                            ->helperText('Displays this article as the large card at the top of the Insights page.'),
                    ]),

                Grid::make(1)->columnSpan(1)->schema([
                    PublicationFields::section(),

                    Section::make('Cover')->schema([
                        FileUpload::make('cover_path')
                            ->label('Cover image')
                            ->image()
                            ->imageEditor()
                            ->directory('posts')
                            ->disk('public'),
                    ]),

                    Section::make('Article download')
                        ->description('Each Insight can deliver a different private file after the visitor submits the form.')
                        ->schema([
                            FileUpload::make('lead_magnet_file_path')
                                ->label('Downloadable file')
                                ->directory('lead-magnets')
                                ->disk('local')
                                ->visibility('private')
                                ->acceptedFileTypes([
                                    'application/pdf',
                                    'application/zip',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ]),
                            Toggle::make('lead_magnet_allow_download')
                                ->label('Download file after submission')
                                ->default(true)
                                ->helperText('When enabled, the visitor’s browser downloads the file.'),
                            Toggle::make('lead_magnet_send_email')
                                ->label('Email file to visitor')
                                ->default(false)
                                ->helperText('When enabled, the same file is attached to an email. Delivery success and response code are logged below.'),
                            FileUpload::make('lead_magnet_image_path')
                                ->label('Banner background')
                                ->image()
                                ->imageEditor()
                                ->directory('posts/lead-magnets')
                                ->disk('public'),
                        ]),
                ]),
            ]),
            SvgIconUpload::make('lead_magnet_cta_icon', 'Download button icon'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_path')
                    ->label('')
                    ->disk('public')
                    ->height(40)
                    ->width(64),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Post $record): string => (string) $record->getTranslation('title'))
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas(
                        'translations',
                        fn (Builder $q) => $q->where('title', 'like', "%{$search}%"),
                    ))
                    ->limit(50)
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->getStateUsing(fn (Post $record): string => (string) ($record->category?->getTranslation('name') ?? '—'))
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')->badge(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Main article')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('translations_count')
                    ->label('Locales')
                    ->counts('translations')
                    ->badge()
                    ->color(fn (int $state): string => $state >= 3 ? 'success' : 'warning')
                    ->formatStateUsing(fn (int $state): string => "{$state}/3"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(PublicationStatus::options()),

                Tables\Filters\SelectFilter::make('category')
                    ->relationship(
                        'category',
                        'name',
                        fn (Builder $query): Builder => $query->withTranslations()->ordered(),
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (PostCategory $record): string => (string) $record->getTranslation('name'),
                    ),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Main article'),
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
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [LeadMagnetDeliveriesRelationManager::class];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['translations', 'category.translations', 'author'])
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
