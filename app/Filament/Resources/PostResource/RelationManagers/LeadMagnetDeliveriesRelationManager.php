<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\RelationManagers;

use App\Models\LeadMagnetDelivery;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

final class LeadMagnetDeliveriesRelationManager extends RelationManager
{
    protected static string $relationship = 'leadMagnetDeliveries';

    protected static ?string $title = 'Lead magnet delivery log';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('email_status')
                    ->label('Email')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('response_code')
                    ->label('Response')
                    ->badge()
                    ->placeholder('—')
                    ->color(fn (?int $state): string => $state === 200 ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('downloaded_at')
                    ->label('Downloaded')
                    ->boolean()
                    ->getStateUsing(fn (LeadMagnetDelivery $record): bool => $record->downloaded_at !== null),
                Tables\Columns\TextColumn::make('error_message')
                    ->label('Error')
                    ->limit(60)
                    ->tooltip(fn (LeadMagnetDelivery $record): ?string => $record->error_message)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')->label('Requested')->dateTime()->sortable(),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public function isReadOnly(): bool
    {
        return true;
    }
}
