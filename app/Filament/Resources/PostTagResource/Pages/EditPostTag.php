<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostTagResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\PostTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPostTag extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = PostTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
