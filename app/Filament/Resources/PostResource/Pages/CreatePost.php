<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

final class CreatePost extends CreateRecord
{
    use HandlesTranslations;

    protected static string $resource = PostResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    /**
     * Recalculate reading time from the saved content.
     */
    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $record->update(['reading_minutes' => $record->calculateReadingMinutes()]);
    }
}
