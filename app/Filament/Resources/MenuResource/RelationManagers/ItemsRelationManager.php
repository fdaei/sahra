<?php

declare(strict_types=1);

namespace App\Filament\Resources\MenuResource\RelationManagers;

use App\Filament\Support\TranslatableForm;
use App\Models\MenuItem;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Menu links.
 *
 * An item points at either a named route (locale-aware — survives slug edits)
 * or a raw URL. Footer column headings are items with neither, rendered as
 * plain text with their children beneath.
 */
final class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Menu items';

    public function form(Form $form): Form
    {
        return $form->schema([
            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.label")
                    ->label('Label')
                    ->required($locale === config('locales.fallback'))
                    ->maxLength(150),
            ], 'Label'),

            Section::make('Destination')
                ->columns(2)
                ->schema([
                    Select::make('route_name')
                        ->label('Named route')
                        ->options(self::routeOptions())
                        ->searchable()
                        ->native(false)
                        ->live()
                        ->helperText('Preferred — automatically carries the active locale.'),

                    TextInput::make('url')
                        ->label('Or external URL')
                        ->maxLength(500)
                        ->disabled(fn (Get $get): bool => filled($get('route_name')))
                        ->helperText('Used only when no named route is selected.'),

                    Select::make('target')
                        ->options([
                            '_self' => 'Same tab',
                            '_blank' => 'New tab',
                        ])
                        ->default('_self')
                        ->native(false),

                    Select::make('parent_id')
                        ->label('Parent item')
                        ->options(fn (): array => $this->getOwnerRecord()
                            ->items()
                            ->whereNull('parent_id')
                            ->with('translations')
                            ->get()
                            ->mapWithKeys(fn (MenuItem $item): array => [
                                $item->id => (string) $item->getTranslation('label'),
                            ])
                            ->all())
                        ->native(false)
                        ->helperText('Footer columns: set a parent to nest links.'),
                ]),

            Section::make()
                ->columns(3)
                ->schema([
                    TextInput::make('sort_order')->numeric()->default(0),

                    Toggle::make('is_cta')
                        ->label('Render as button')
                        ->helperText("The header's Let's Talk CTA."),

                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->getStateUsing(fn (MenuItem $record): string => (string) $record->getTranslation('label'))
                    ->description(fn (MenuItem $record): ?string => $record->parent_id !== null ? '↳ nested' : null)
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('route_name')
                    ->label('Destination')
                    ->getStateUsing(fn (MenuItem $record): string => $record->route_name ?? $record->url ?? '— heading —')
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_cta')->label('CTA')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(fn (array $data): Model => $this->persist($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, MenuItem $record): array {
                        $record->loadMissing('translations');

                        return TranslatableForm::hydrate($record, $data);
                    })
                    ->using(fn (MenuItem $record, array $data): Model => $this->persist($data, $record)),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function persist(array $data, ?MenuItem $record = null): Model
    {
        return DB::transaction(function () use ($data, $record): Model {
            [$attributes, $translations] = TranslatableForm::split($data);

            if ($record === null) {
                $record = $this->getRelationship()->create($attributes);
            } else {
                $record->update($attributes);
            }

            TranslatableForm::persist($record, $translations);

            return $record;
        });
    }

    /**
     * Public named routes an editor may link to.
     *
     * @return array<string, string>
     */
    private static function routeOptions(): array
    {
        $names = [
            'home' => 'Home',
            'work.index' => 'Work',
            'services' => 'Services',
            'about' => 'About',
            'insights.index' => 'Insights',
            'contact' => 'Contact',
            'legal.privacy' => 'Privacy Policy',
            'legal.terms' => 'Terms & Conditions',
        ];

        return array_filter(
            $names,
            fn (string $name): bool => Route::has($name),
            ARRAY_FILTER_USE_KEY,
        );
    }
}
