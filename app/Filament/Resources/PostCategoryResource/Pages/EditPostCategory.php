<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostCategoryResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPostCategory extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = PostCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
