<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Support\TranslatableForm;
use App\Models\TeamMember;
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
 * About-page team grid. Figma 908:1576, card 992:2644.
 */
final class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.name")
                    ->label('Name')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150),

                TextInput::make("translations.{$locale}.role")
                    ->label('Role')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150),

                TextInput::make("translations.{$locale}.photo_alt")
                    ->label('Photo alt text')
                    ->maxLength(300),
            ]),

            Section::make()
                ->columns(2)
                ->schema([
                    FileUpload::make('photo_path')
                        ->label('Portrait')
                        ->image()
                        ->imageEditor()
                        ->directory('team')
                        ->disk('public')
                        ->maxSize(4096)
                        ->columnSpanFull(),

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
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->size(48),

                Tables\Columns\TextColumn::make('name')
                    ->getStateUsing(fn (TeamMember $record): string => (string) $record->getTranslation('name'))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('role')
                    ->getStateUsing(fn (TeamMember $record): string => (string) $record->getTranslation('role'))
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_active')->boolean(),

                Tables\Columns\TextColumn::make('translations_count')
                    ->label('Locales')
                    ->counts('translations')
                    ->badge()
                    ->color(fn (int $state): string => $state >= 3 ? 'success' : 'warning')
                    ->formatStateUsing(fn (int $state): string => "{$state}/3"),
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
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }
}
