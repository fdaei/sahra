<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Support\TranslatableForm;
use App\Models\ProjectImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Content-showcase gallery. Figma 1323:7541 "Content Showcase".
 */
final class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Showcase images';

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('path')
                ->label('Image')
                ->image()
                ->imageEditor()
                ->directory('projects/showcase')
                ->disk('public')
                ->required()
                ->columnSpanFull(),

            TextInput::make('sort_order')
                ->numeric()
                ->default(0),

            TranslatableForm::tabs(fn (string $locale): array => [
                TextInput::make("translations.{$locale}.alt")
                    ->label('Alt text')
                    ->maxLength(300),
            ], 'Alt text'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Image')
                    ->disk('public')
                    ->height(60),

                Tables\Columns\TextColumn::make('alt')
                    ->label('Alt text')
                    ->getStateUsing(fn (ProjectImage $record): string => (string) $record->getTranslation('alt'))
                    ->limit(60),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data): Model {
                        return DB::transaction(function () use ($data): Model {
                            [$attributes, $translations] = TranslatableForm::split($data);

                            $record = $this->getRelationship()->create($attributes);
                            TranslatableForm::persist($record, $translations);

                            return $record;
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateRecordDataUsing(function (array $data, ProjectImage $record): array {
                        $record->loadMissing('translations');

                        return TranslatableForm::hydrate($record, $data);
                    })
                    ->using(function (ProjectImage $record, array $data): Model {
                        return DB::transaction(function () use ($record, $data): Model {
                            [$attributes, $translations] = TranslatableForm::split($data);

                            $record->update($attributes);
                            TranslatableForm::persist($record, $translations);

                            return $record;
                        });
                    }),

                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
