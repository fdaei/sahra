<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Support\TranslatableForm;
use App\Models\Client;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trust-proof logo strip. Figma 1419:9205.
 */
final class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.name")
                    ->label('Client name')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150),

                TextInput::make("translations.{$locale}.logo_alt")
                    ->label('Logo alt text')
                    ->maxLength(300),
            ]),

            Section::make()
                ->columns(2)
                ->schema([
                    FileUpload::make('logo_path')
                        ->label('Logo (SVG preferred)')
                        ->directory('clients')
                        ->disk('public')
                        ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/webp'])
                        ->maxSize(1024)
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('website_url')
                        ->label('Website')
                        ->url()
                        ->maxLength(500),

                    TextInput::make('sort_order')->numeric()->default(0),

                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('')
                    ->disk('public')
                    ->height(32),

                Tables\Columns\TextColumn::make('name')
                    ->getStateUsing(fn (Client $record): string => (string) $record->getTranslation('name'))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('website_url')
                    ->label('Website')
                    ->url(fn (Client $record): ?string => $record->website_url)
                    ->openUrlInNewTab()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }
}
