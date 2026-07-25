<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * URL redirects, so slugs can change without breaking inbound links.
 */
final class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('source_path')
                        ->label('From')
                        ->required()
                        ->maxLength(500)
                        ->unique(ignoreRecord: true)
                        ->prefix(config('app.url').'/')
                        ->helperText('Path without a leading slash, e.g. "en/old-page".'),

                    TextInput::make('destination_path')
                        ->label('To')
                        ->required()
                        ->maxLength(500)
                        ->prefix(config('app.url').'/'),

                    Select::make('status_code')
                        ->options([
                            301 => '301 — Permanent',
                            302 => '302 — Temporary',
                        ])
                        ->default(301)
                        ->required()
                        ->native(false),

                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('source_path')
                    ->label('From')
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('destination_path')
                    ->label('To')
                    ->searchable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status_code')->badge(),

                Tables\Columns\TextColumn::make('hits')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_hit_at')
                    ->dateTime('M j, Y')
                    ->placeholder('Never')
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
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
