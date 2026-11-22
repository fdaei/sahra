<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Services\Backup\SqliteBackup;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ManageBackups extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Website setup';
    protected static string $view = 'filament.pages.manage-backups';

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('admin.navigation.groups.Website setup');
    }

    public static function getNavigationLabel(): string
    {
        return __('Backups');
    }

    public function getTitle(): string
    {
        return __('Backups');
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('download')->label(__('Download backup'))->icon('heroicon-o-arrow-down-tray')
            ->requiresConfirmation()
            ->action(function (): ?BinaryFileResponse {
                abort_unless(static::canAccess(), 403);
                try {
                    $path = app(SqliteBackup::class)->create();
                } catch (\Throwable $exception) {
                    report($exception);
                    Notification::make()->danger()->title(__('Backup failed'))->body(__('Check the server logs and database configuration.'))->send();
                    return null;
                }
                return response()->download($path, 'sahra-backup-'.now()->format('Y-m-d-His').'.zip', [
                    'Cache-Control' => 'private, no-store',
                ])->deleteFileAfterSend();
            })];
    }
}
