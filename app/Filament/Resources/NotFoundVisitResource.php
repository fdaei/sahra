<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\NotFoundVisitResource\Pages;
use App\Models\NotFoundVisit;
use App\Models\Redirect;
use App\Rules\RedirectDestination;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;

final class NotFoundVisitResource extends Resource
{
    protected static ?string $model = NotFoundVisit::class;
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';
    protected static ?string $navigationGroup = 'Advanced';
    protected static ?string $navigationLabel = '404 reports';

    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('last_seen_at', 'desc')->columns([
            Tables\Columns\TextColumn::make('path')->label('Path')->searchable()->wrap(),
            Tables\Columns\TextColumn::make('hits')->label('Hits')->sortable(),
            Tables\Columns\TextColumn::make('first_seen_at')->label('First seen')->dateTime()->sortable(),
            Tables\Columns\TextColumn::make('last_seen_at')->label('Last seen')->dateTime()->sortable(),
        ])->actions([
            Tables\Actions\Action::make('create_redirect')
                ->label(__('Create redirect'))
                ->icon('heroicon-o-arrow-uturn-right')
                ->form(fn (NotFoundVisit $record): array => [
                    TextInput::make('destination_path')->label('To')->required()->maxLength(500)
                        ->rules([new RedirectDestination($record->path)]),
                    Select::make('status_code')->options(Redirect::STATUSES)->in(array_keys(Redirect::STATUSES))->default(301)->required(),
                ])
                ->action(function (NotFoundVisit $record, array $data): void {
                    abort_unless(auth()->user()?->isAdmin() && auth()->user()->can('create', Redirect::class), 403);
                    if (Redirect::query()->where('source_path', $record->path)->exists()) {
                        Notification::make()->warning()->title(__('A redirect already exists for this path.'))->send();
                        return;
                    }
                    Redirect::create(['source_path' => $record->path, 'destination_path' => $data['destination_path'],
                        'status_code' => $data['status_code'], 'is_active' => true]);
                    Notification::make()->success()->title(__('Redirect created'))->send();
                }),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListNotFoundVisits::route('/')];
    }
}
