<?php

declare(strict_types=1);

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\MediaResource;
use App\Models\Media;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditMedia extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn (Media $record): bool => $record->isLibraryFile())
                ->after(fn (Media $record) => MediaResource::deleteFiles($record)),
        ];
    }
}
