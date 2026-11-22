<?php

declare(strict_types=1);

namespace App\Filament\Resources\NotFoundVisitResource\Pages;

use App\Filament\Resources\NotFoundVisitResource;
use Filament\Resources\Pages\ListRecords;

final class ListNotFoundVisits extends ListRecords
{
    protected static string $resource = NotFoundVisitResource::class;
}
