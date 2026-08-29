<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\PublicationStatus;
use App\Filament\Resource;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\PublicationFields;
use App\Filament\Support\SvgIconUpload;
use App\Filament\Support\TranslatableForm;
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
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
 * Services. Figma 1323:7189 (page), 1419:9279 (home cloud).
 *
 * Independently manageable — sortable, publishable, translatable — but there
 * is deliberately no public detail route; the slug is an in-page anchor only.
 */
final class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Website content';

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

                Textarea::make("translations.{$locale}.description")
                    ->label('Description')
                    ->helperText('A short explanation shown on the Services page.')
                    ->rows(3),

                TagsInput::make("translations.{$locale}.features")
                    ->label('What is included?')
                    ->placeholder('Add an item')
                    ->helperText('Add short items such as “Content planning” or “Monthly reporting”.'),

                Section::make('Advanced (optional)')
                    ->description('Usually you do not need to change these fields.')
                    ->collapsed()
                    ->schema([
                        TextInput::make("translations.{$locale}.slug")
                            ->label('Page anchor')
                            ->required($locale === config('locales.fallback'))
                            ->maxLength(200)
                            ->helperText("Used in the page link: /{$locale}/services#slug."),

                        TextInput::make("translations.{$locale}.image_alt")
                            ->label('Image description for accessibility')
                            ->helperText('Describe the image briefly for visitors using screen readers.')
                            ->maxLength(300),
                    ]),
            ]),

            Grid::make(3)->schema([
                Section::make('Display')
                    ->columnSpan(2)
                    ->schema([
                        Toggle::make('show_on_home')
                            ->label('Show this service on the home page')
                            ->helperText('Turn this off to keep it only on the Services page.')
                            ->default(true),

                        Select::make('home_orbit_group')
                            ->label('Position in the home capability map')
                            ->options([
                                'active' => 'Active (dark pill with image)',
                                'brand' => 'Muted — Brand side',
                                'product' => 'Muted — Product side',
                            ])
                            ->placeholder('Do not show in the capability map')
                            ->helperText('Active items use the uploaded service image on hover.'),

                        TextInput::make('external_url')
                            ->label('Capability-map link')
                            ->url()
                            ->maxLength(500)
                            ->helperText('Optional. When empty, the item links to its section on the Services page.'),

                        Toggle::make('show_on_services_page')
                            ->label('Show as a full section on the Services page')
                            ->default(true),

                        Section::make('Advanced display settings')
                            ->description('Only change these when adjusting the site layout.')
                            ->collapsed()
                            ->columns(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Display order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first.'),

                                SvgIconUpload::make('icon', 'Service icon'),
                            ]),
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
                    ->label('Shown on home')
                    ->boolean(),

                Tables\Columns\TextColumn::make('home_orbit_group')
                    ->label('Home map')
                    ->badge()
                    ->placeholder('Not shown')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'active' => 'Active',
                        'brand' => 'Brand side',
                        'product' => 'Product side',
                        default => 'Not shown',
                    }),

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
     * @return array<string, PageRegistration>
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
