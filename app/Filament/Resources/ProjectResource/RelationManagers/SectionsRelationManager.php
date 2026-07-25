<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Enums\SectionType;
use App\Filament\Support\TranslatableForm;
use App\Models\PageSection;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Manages the polymorphic PageSection children of a Page or Project.
 *
 * Registered on both PageResource and ProjectResource — the morphMany
 * relationship is named `sections` on both models, so one class serves both
 * rather than duplicating ~250 lines per parent type.
 *
 * Sections whose type `hasItems()` expose a sortable repeater of SectionItems
 * (KPI counters, process steps, goals, strategy pillars, deliverables,
 * result stats). Each item is itself translatable.
 */
final class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $title = 'Content sections';

    protected static ?string $recordTitleAttribute = 'type';

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(3)
                ->schema([
                    Select::make('type')
                        ->options(SectionType::options())
                        ->required()
                        ->live()
                        ->native(false)
                        ->columnSpan(1)
                        ->helperText('Selects which layout renders this block.'),

                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->columnSpan(1),

                    Toggle::make('is_visible')
                        ->label('Visible')
                        ->default(true)
                        ->columnSpan(1)
                        ->helperText('Hide without deleting the content.'),
                ]),

            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.eyebrow")
                    ->label('Eyebrow')
                    ->maxLength(150)
                    ->helperText('Small gold label above the title.'),

                TextInput::make("translations.{$locale}.title")
                    ->label('Title')
                    ->maxLength(300),

                TextInput::make("translations.{$locale}.subtitle")
                    ->label('Subtitle')
                    ->maxLength(300),

                Textarea::make("translations.{$locale}.description")
                    ->label('Description')
                    ->rows(3),

                RichEditor::make("translations.{$locale}.content")
                    ->label('Rich content')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 'bulletList', 'orderedList',
                        'h2', 'h3', 'blockquote', 'undo', 'redo',
                    ])
                    ->visible(fn (Get $get): bool => $get('type') === SectionType::RichText->value),

                TextInput::make("translations.{$locale}.primary_cta_label")
                    ->label('Primary button label')
                    ->maxLength(100),

                TextInput::make("translations.{$locale}.primary_cta_url")
                    ->label('Primary button URL')
                    ->maxLength(500),

                TextInput::make("translations.{$locale}.secondary_cta_label")
                    ->label('Secondary button label')
                    ->maxLength(100),

                TextInput::make("translations.{$locale}.secondary_cta_url")
                    ->label('Secondary button URL')
                    ->maxLength(500),

                TextInput::make("translations.{$locale}.image_alt")
                    ->label('Image alt text')
                    ->maxLength(300),
            ]),

            FileUpload::make('image_path')
                ->label('Section image')
                ->image()
                ->imageEditor()
                ->directory('sections')
                ->disk('public')
                ->maxSize(6144)
                ->columnSpanFull(),

            /*
             | Repeatable cards. Stored as SectionItem rows, but edited inline
             | so an editor manages a whole section on one screen.
             |
             | Note: the repeater writes a nested `items` array which
             | handleSave() below explodes into rows — Filament cannot persist
             | a HasMany-with-translations directly.
             */
            Repeater::make('items')
                ->label('Cards')
                ->visible(fn (Get $get): bool => $get('type') !== null
                    && SectionType::from($get('type'))->hasItems())
                ->orderColumn('sort_order')
                ->reorderableWithButtons()
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['translations'][config('locales.fallback')]['title'] ?? null)
                ->defaultItems(0)
                ->columnSpanFull()
                ->schema([
                    TranslatableForm::tabs(fn (string $locale): array => [
                        TextInput::make("translations.{$locale}.value")
                            ->label('Value')
                            ->maxLength(50)
                            ->helperText('Short display value: "+70k", "+189%", "01".'),

                        TextInput::make("translations.{$locale}.title")
                            ->label('Title')
                            ->maxLength(200),

                        Textarea::make("translations.{$locale}.description")
                            ->label('Description')
                            ->rows(2),
                    ]),

                    TextInput::make('icon')
                        ->label('Icon name')
                        ->maxLength(50)
                        ->helperText('A lucide-vue-next icon, e.g. "check-circle".'),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (SectionType $state): string => $state->getLabel()),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (PageSection $record): string => (string) $record->getTranslation('title'))
                    ->limit(50),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Cards')
                    ->counts('items')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(fn (array $data): Model => $this->persist($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(fn (array $data, PageSection $record): array => $this->hydrate($data, $record))
                    ->using(fn (PageSection $record, array $data): Model => $this->persist($data, $record)),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Create or update a section together with its translations and items,
     * inside one transaction.
     *
     * @param  array<string, mixed>  $data
     */
    private function persist(array $data, ?PageSection $record = null): Model
    {
        return DB::transaction(function () use ($data, $record): Model {
            $items = $data['items'] ?? [];
            unset($data['items']);

            [$attributes, $translations] = TranslatableForm::split($data);

            if ($record === null) {
                $record = $this->getRelationship()->create($attributes);
            } else {
                $record->update($attributes);
            }

            TranslatableForm::persist($record, $translations);

            $this->syncItems($record, $items);

            return $record;
        });
    }

    /**
     * Replace the section's items with the submitted set.
     *
     * Deleting and recreating keeps the repeater's ordering authoritative and
     * avoids orphan rows; section items carry no external references, so there
     * is nothing to preserve across the swap.
     *
     * @param  array<int, array<string, mixed>>  $items
     */
    private function syncItems(PageSection $section, array $items): void
    {
        $section->items()->delete();

        foreach (array_values($items) as $index => $item) {
            [$attributes, $translations] = TranslatableForm::split($item);

            $created = $section->items()->create([
                'sort_order' => $index,
                'is_visible' => true,
                'icon' => $attributes['icon'] ?? null,
                'image_path' => $attributes['image_path'] ?? null,
            ]);

            TranslatableForm::persist($created, $translations);
        }
    }

    /**
     * Load existing translations and items back into the form.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function hydrate(array $data, PageSection $record): array
    {
        $record->loadMissing(['translations', 'items.translations']);

        $data = TranslatableForm::hydrate($record, $data);

        $data['items'] = $record->items
            ->map(function ($item): array {
                $itemData = TranslatableForm::hydrate($item, []);
                $itemData['icon'] = $item->icon;
                $itemData['image_path'] = $item->image_path;

                return $itemData;
            })
            ->all();

        return $data;
    }
}
