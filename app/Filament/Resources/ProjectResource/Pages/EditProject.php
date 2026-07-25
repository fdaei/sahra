<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditProject extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = ProjectResource::class;

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
}
