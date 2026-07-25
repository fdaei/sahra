<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPost extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn (): string => $this->getRecord()->url(config('locales.fallback')))
                ->openUrlInNewTab()
                ->visible(fn (): bool => $this->getRecord()->isPublished()),

            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $record->updateQuietly(['reading_minutes' => $record->calculateReadingMinutes()]);
    }
}
