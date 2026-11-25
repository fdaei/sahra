<?php

declare(strict_types=1);

namespace App\Filament\Resources\InternalLinkResource\Pages;

use App\Filament\Resources\InternalLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListInternalLinks extends ListRecords
{
    protected static string $resource = InternalLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
