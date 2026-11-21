<?php

declare(strict_types=1);

namespace App\Filament\Resources\MenuResource\RelationManagers;

use App\Filament\Support\SvgIconUpload;
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

                    SvgIconUpload::make('icon', 'Button icon'),
                    SvgIconUpload::make('hover_icon', 'Button hover icon'),

                    Select::make('parent_id')
                        ->label('Parent item')
                        ->options(fn (?MenuItem $record): array => $this->parentOptions($record))
                        ->native(false)
                        ->helperText('Header: nested items open as a dropdown (up to two levels). Footer: items under a heading form a column.'),

                    Select::make('children_source')
                        ->label('Generate submenu from')
                        ->options(MenuItem::CHILDREN_SOURCES)
                        ->placeholder('Nothing — nested items only')
                        ->native(false)
                        ->helperText('E.g. on "Insights": the dropdown lists every category and subcategory automatically.'),
                ]),

            Section::make()
                ->columns(3)
                ->schema([
                    TextInput::make('sort_order')->numeric()->default(0),

                    Toggle::make('is_cta')
                        ->label('Render as button')
                        ->helperText('The header\'s Book Consultation CTA.'),

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
                    ->description(fn (MenuItem $record): ?string => match (true) {
                        $record->children_source !== null => '▾ '.(MenuItem::CHILDREN_SOURCES[$record->children_source] ?? $record->children_source),
                        $record->parent_id !== null => '↳ nested',
                        default => null,
                    })
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
     * Possible parents: top-level items and their direct children (menus
     * are at most three levels), never the item itself or its children.
     *
     * @return array<int, string>
     */
    private function parentOptions(?MenuItem $record): array
    {
        $items = $this->getOwnerRecord()->items()->with('translations')->get();
        $byId = $items->keyBy('id');

        return $items
            ->filter(function (MenuItem $item) use ($record, $byId): bool {
                if ($record !== null && ($item->id === $record->id || $item->parent_id === $record->id)) {
                    return false;
                }
                $parent = $item->parent_id === null ? null : $byId->get($item->parent_id);

                return $item->parent_id === null || ($parent !== null && $parent->parent_id === null);
            })
            ->mapWithKeys(fn (MenuItem $item): array => [
                $item->id => ($item->parent_id !== null ? '↳ ' : '').(string) $item->getTranslation('label'),
            ])
            ->all();
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
