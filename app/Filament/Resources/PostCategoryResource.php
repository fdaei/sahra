<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PostCategoryResource\Pages;
use App\Filament\Support\TranslatableForm;
use App\Models\PostCategory;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Blog categories. Locale-scoped slugs — the same slug string may exist in
 * different locales, but never twice within one.
 */
final class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Articles';

    protected static ?string $navigationLabel = 'Article categories';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.name")
                    ->label('Name')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150)
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
                    ->maxLength(150),
            ]),

            Section::make()
                ->columns(2)
                ->schema([
                    Select::make('parent_id')
                        ->label('Parent category')
                        ->placeholder('None — top-level category')
                        ->options(fn (?PostCategory $record): array => self::pathOptions($record))
                        ->searchable()
                        ->native(false)
                        ->helperText('Subcategories appear under their parent in the site menu and filters.'),

                    TextInput::make('sort_order')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->getStateUsing(fn (PostCategory $record): string => (string) $record->getTranslation('name'))
                    ->description(fn (PostCategory $record): ?string => $record->parent_id === null
                        ? null
                        : '↳ '.collect($record->ancestors())->map(fn (PostCategory $c): string => (string) $c->getTranslation('name'))->implode(' › '))
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->getStateUsing(fn (PostCategory $record): string => (string) $record->getTranslation('slug'))
                    ->color('gray'),

                Tables\Columns\TextColumn::make('translations_count')
                    ->label('Locales')
                    ->counts('translations')
                    ->badge()
                    ->color(fn (int $state): string => $state >= 3 ? 'success' : 'warning')
                    ->formatStateUsing(fn (int $state): string => "{$state}/3"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->options(fn (): array => self::pathOptions(null)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Every category labelled with its full path ("Marketing › SEO"),
     * minus the record and its descendants so no cycle can be chosen.
     *
     * @return array<int, string>
     */
    public static function pathOptions(?PostCategory $record): array
    {
        $excluded = $record === null ? [] : [$record->id, ...$record->descendantIds()];
        $all = PostCategory::query()->with('translations')->ordered()->get()->keyBy('id');

        return $all
            ->reject(fn (PostCategory $c): bool => in_array($c->id, $excluded, true))
            ->map(function (PostCategory $c) use ($all): string {
                $names = [(string) $c->getTranslation('name')];
                for ($i = 0, $p = $c->parent_id; $p !== null && $i < PostCategory::MAX_DEPTH && $all->has($p); $i++) {
                    array_unshift($names, (string) $all[$p]->getTranslation('name'));
                    $p = $all[$p]->parent_id;
                }

                return implode(' › ', $names);
            })
            ->sort()
            ->all();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostCategories::route('/'),
            'create' => Pages\CreatePostCategory::route('/create'),
            'edit' => Pages\EditPostCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['translations', 'parent.translations']);
    }
}
