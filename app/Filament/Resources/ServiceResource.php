<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\PublicationFields;
use App\Filament\Support\TranslatableForm;
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Services. Figma 1323:7189 (page), 1419:9279 (home cloud).
 *
 * Independently manageable — sortable, publishable, translatable — but there
 * is deliberately no public detail route; the slug is an in-page anchor only.
 */
final class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(200)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set) use ($locale): void {
                        $set(
                            "translations.{$locale}.slug",
                            TranslatableForm::slugify($state, $locale),
                        );
                    }),

                TextInput::make("translations.{$locale}.slug")
                    ->label('Anchor slug')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(200)
                    ->helperText("In-page anchor: /{$locale}/services#slug. Not a route."),

                Textarea::make("translations.{$locale}.description")
                    ->label('Description')
                    ->rows(3),

                TagsInput::make("translations.{$locale}.features")
                    ->label('Feature list')
                    ->placeholder('Add a feature')
                    ->helperText('Bullet points shown beside the service image.'),

                TextInput::make("translations.{$locale}.image_alt")
                    ->label('Image alt text')
                    ->maxLength(300),
            ]),

            Grid::make(3)->schema([
                Section::make('Settings')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Controls the order of sections on /services.'),

                        TextInput::make('icon')
                            ->label('Icon name')
                            ->maxLength(50)
                            ->helperText('A lucide-vue-next icon name.'),

                        Toggle::make('show_on_home')
                            ->label('Show in home services cloud')
                            ->default(true),
                    ]),

                Grid::make(1)->columnSpan(1)->schema([
                    PublicationFields::section(),

                    Section::make('Media')->schema([
                        FileUpload::make('image_path')
                            ->label('Service image')
                            ->image()
                            ->imageEditor()
                            ->directory('services')
                            ->disk('public'),
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
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(48),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (Service $record): string => (string) $record->getTranslation('title'))
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas(
                        'translations',
                        fn (Builder $q) => $q->where('title', 'like', "%{$search}%"),
                    ))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('status')->badge(),

                Tables\Columns\IconColumn::make('show_on_home')
                    ->label('On home')
                    ->boolean(),

                Tables\Columns\TextColumn::make('projects_count')
                    ->label('Projects')
                    ->counts('projects')
                    ->badge()
                    ->color('gray'),

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
                Tables\Filters\TernaryFilter::make('show_on_home'),
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
                ]),
            ]);
    }

    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('translations')
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
