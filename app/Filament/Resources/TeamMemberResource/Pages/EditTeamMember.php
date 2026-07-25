<?php

declare(strict_types=1);

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\TeamMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditTeamMember extends EditRecord
{
    use HandlesTranslations;

    protected static string $resource = TeamMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\ForceDeleteAction::make(),
        ];
    }
}
