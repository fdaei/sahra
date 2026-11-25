<?php

declare(strict_types=1);

namespace App\Filament\Resources\InternalLinkResource\Pages;

use App\Filament\Resources\InternalLinkResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateInternalLink extends CreateRecord
{
    protected static string $resource = InternalLinkResource::class;
}
