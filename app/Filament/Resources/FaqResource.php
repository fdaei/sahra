<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Filament\Support\TranslatableForm;
use App\Models\Faq;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Home FAQ accordion. Figma 1419:9272.
 */
final class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Questions & answers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.question")
                    ->label('Question')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(300),

                Textarea::make("translations.{$locale}.answer")
                    ->label('Answer')
                    ->required($locale === config('locales.fallback'))
                    ->rows(4),
            ]),

            Section::make('Display options')
                ->description('The defaults are suitable for most questions.')
                ->collapsed()
                ->columns(2)
                ->schema([
                    TextInput::make('sort_order')
                        ->label('Display order')
                        ->helperText('Lower numbers appear first.')
                        ->numeric()
                        ->default(0),
                    Toggle::make('is_active')
                        ->label('Show this question')
                        ->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->getStateUsing(fn (Faq $record): string => (string) $record->getTranslation('question'))
                    ->limit(80)
                    ->weight('medium'),

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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }
}
