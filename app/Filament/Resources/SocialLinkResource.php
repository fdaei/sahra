<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SocialLinkResource\Pages;
use App\Models\SocialLink;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Social profiles. Figma: footer 1419:9317, contact 1363:8934.
 * Not translatable — URLs and platform names are locale-independent.
 */
final class SocialLinkResource extends Resource
{
    protected static ?string $model = SocialLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Website setup';

    protected static ?string $navigationLabel = 'Social media links';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('platform')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true)
                        ->helperText('Machine key, e.g. "instagram".'),

                    TextInput::make('label')
                        ->required()
                        ->maxLength(100)
                        ->helperText('Display text, e.g. "Instagram".'),

                    TextInput::make('url')
                        ->required()
                        ->url()
                        ->maxLength(500)
                        ->columnSpanFull(),

                    TextInput::make('icon')
                        ->required()
                        ->maxLength(50)
                        ->helperText('lucide-vue-next icon name, e.g. "instagram".'),

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
                Tables\Columns\TextColumn::make('label')->weight('medium'),

                Tables\Columns\TextColumn::make('url')
                    ->url(fn (SocialLink $record): string => $record->url)
                    ->openUrlInNewTab()
                    ->color('gray')
                    ->limit(40),

                Tables\Columns\TextColumn::make('icon')->badge()->color('gray'),

                Tables\Columns\IconColumn::make('is_active')->boolean(),
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
            'index' => Pages\ListSocialLinks::route('/'),
            'create' => Pages\CreateSocialLink::route('/create'),
            'edit' => Pages\EditSocialLink::route('/{record}/edit'),
        ];
    }
}
