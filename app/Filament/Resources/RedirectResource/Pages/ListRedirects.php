<?php

declare(strict_types=1);

namespace App\Filament\Resources\RedirectResource\Pages;

use App\Filament\Resources\RedirectResource;
use App\Models\Redirect;
use App\Services\Redirects\RedirectCsv;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')->label(__('Export CSV'))->icon('heroicon-o-arrow-down-tray')->color('gray')
                ->action(function (): StreamedResponse {
                    abort_unless(static::getResource()::canViewAny(), 403);
                    return response()->streamDownload(function (): void {
                        $out = fopen('php://output', 'wb'); fwrite($out, "\xEF\xBB\xBF");
                        fputcsv($out, ['source', 'destination', 'status', 'match_type', 'active', 'hits', 'notes'], ',', '"', '');
                        Redirect::query()->orderBy('id')->each(function (Redirect $redirect) use ($out): void {
                            $fields = [$redirect->source_path, $redirect->destination_path, $redirect->status_code, $redirect->match_type, $redirect->is_active ? 1 : 0, $redirect->hits, $redirect->notes];
                            $fields = array_map(static fn ($value) => is_string($value) && preg_match('/^[=+@\-\t\r]/', $value) ? "'".$value : $value, $fields);
                            fputcsv($out, $fields, ',', '"', '');
                        });
                        fclose($out);
                    }, 'redirects-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                }),
            Actions\Action::make('import')->label(__('Import CSV'))->icon('heroicon-o-arrow-up-tray')->color('gray')
                ->modalDescription(__('Import source, destination, status, match_type and active columns. Existing rules are skipped unless updating is enabled.'))
                ->form([
                    FileUpload::make('file')->label('CSV file')->disk('local')->directory('redirect-imports')->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])->maxSize(5120)->required(),
                    Toggle::make('update_existing')->label('Update existing rules')->default(false),
                ])
                ->action(function (array $data): void {
                    abort_unless(static::getResource()::canCreate(), 403);
                    $disk = Storage::disk('local');
                    try { $result = RedirectCsv::import($disk->path($data['file']), (bool) ($data['update_existing'] ?? false)); }
                    finally { $disk->delete($data['file']); }
                    Notification::make()->success()->title(__('Import complete'))->body("{$result['created']} created, {$result['updated']} updated, {$result['skipped']} skipped")->send();
                }),
        ];
    }
}
