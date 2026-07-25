<?php

declare(strict_types=1);

namespace App\Filament\Resources\IndustryResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\IndustryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditIndustry extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = IndustryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
