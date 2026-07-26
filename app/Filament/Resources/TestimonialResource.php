<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Support\TranslatableForm;
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Customer reviews marquee. Figma 1419:9243, card 1419:9251.
 */
final class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.author_name")
                    ->label('Author name')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150),

                TextInput::make("translations.{$locale}.author_role")
                    ->label('Author role')
                    ->maxLength(200),

                Textarea::make("translations.{$locale}.quote")
                    ->label('Quote')
                    ->required($locale === config('locales.fallback'))
                    ->rows(4),

                TextInput::make("translations.{$locale}.avatar_alt")
                    ->label('Avatar alt text')
                    ->maxLength(300),
            ]),

            Section::make()
                ->columns(2)
                ->schema([
                    FileUpload::make('avatar_path')
                        ->label('Avatar')
                        ->image()
                        ->imageEditor()
                        ->avatar()
                        ->directory('testimonials')
                        ->disk('public')
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
                Tables\Columns\ImageColumn::make('avatar_path')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Author')
                    ->getStateUsing(fn (Testimonial $record): string => (string) $record->getTranslation('author_name'))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('quote')
                    ->getStateUsing(fn (Testimonial $record): string => (string) $record->getTranslation('quote'))
                    ->limit(70)
                    ->color('gray'),

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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }
}
