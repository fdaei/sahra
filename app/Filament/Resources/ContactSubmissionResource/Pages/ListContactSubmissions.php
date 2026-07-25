<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Enums\SubmissionStatus;
use App\Filament\Resources\ContactSubmissionResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

final class ListContactSubmissions extends ListRecords
{
    protected static string $resource = ContactSubmissionResource::class;

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),

            'new' => Tab::make('New')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('status', SubmissionStatus::New))
                ->badge(fn (): int => static::getResource()::getModel()::query()->unread()->count()),

            'replied' => Tab::make('Replied')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('status', SubmissionStatus::Replied)),

            'archived' => Tab::make('Archived')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('status', SubmissionStatus::Archived)),
        ];
    }
}
