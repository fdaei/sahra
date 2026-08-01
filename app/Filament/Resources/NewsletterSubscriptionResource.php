<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriptionResource\Pages;
use App\Models\NewsletterSubscription;
use Filament\Forms\Form;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Lead-magnet signups. Figma 1419:9322.
 * Read-only: addresses arrive from the public form and are never hand-edited.
 */
final class NewsletterSubscriptionResource extends Resource
{
    protected static ?string $model = NewsletterSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Messages';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Newsletter subscribers';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('locale')->badge()->color('gray'),

                Tables\Columns\TextColumn::make('source')->badge()->color('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Subscribed')
                    ->boolean()
                    ->getStateUsing(fn (NewsletterSubscription $record): bool => $record->isActive()),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Active only')
                    ->query(fn (Builder $query): Builder => $query->whereNull('unsubscribed_at'))
                    ->default(),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (): StreamedResponse {
                        $rows = NewsletterSubscription::query()
                            ->whereNull('unsubscribed_at')
                            ->orderBy('created_at')
                            ->get(['email', 'locale', 'source', 'created_at']);

                        return response()->streamDownload(function () use ($rows): void {
                            $handle = fopen('php://output', 'wb');
                            fputcsv($handle, ['Email', 'Locale', 'Source', 'Joined']);

                            foreach ($rows as $row) {
                                fputcsv($handle, [
                                    $row->email,
                                    $row->locale,
                                    $row->source,
                                    $row->created_at?->toDateString(),
                                ]);
                            }

                            fclose($handle);
                        }, 'newsletter-'.now()->toDateString().'.csv');
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterSubscriptions::route('/'),
        ];
    }
}
