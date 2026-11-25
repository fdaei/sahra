<?php

declare(strict_types=1);

namespace App\Filament\Resources\InternalLinkResource\Pages;

use App\Filament\Resources\InternalLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditInternalLink extends EditRecord
{
    protected static string $resource = InternalLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
