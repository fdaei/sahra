<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\SubmissionStatus;
use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

/**
 * Contact-form submissions. Figma 1363:8934.
 *
 * Read-only apart from triage status and internal notes — the submitted
 * content is a record of what the visitor sent and must not be editable.
 */
final class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Submissions';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Contact enquiries';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->unread()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Submission')
                ->columns(2)
                ->schema([
                    Placeholder::make('name')
                        ->content(fn (ContactSubmission $record): string => $record->name),

                    Placeholder::make('brand_name')
                        ->label('Brand')
                        ->content(fn (ContactSubmission $record): string => $record->brand_name ?? '—'),

                    Placeholder::make('phone')
                        ->content(fn (ContactSubmission $record): Htmlable => new HtmlString(
                            $record->phone === null
                                ? '—'
                                : '<a class="text-primary-600 underline" href="tel:'.e($record->phone).'">'.e($record->phone).'</a>',
                        )),

                    Placeholder::make('email')
                        ->content(fn (ContactSubmission $record): Htmlable => new HtmlString(
                            $record->email === null
                                ? '—'
                                : '<a class="text-primary-600 underline" href="mailto:'.e($record->email).'">'.e($record->email).'</a>',
                        )),

                    Placeholder::make('services')
                        ->label('Services requested')
                        ->columnSpanFull()
                        ->content(fn (ContactSubmission $record): string => $record->service_titles === null || $record->service_titles === []
                            ? '—'
                            : implode(', ', $record->service_titles)),

                    Placeholder::make('message')
                        ->columnSpanFull()
                        ->content(fn (ContactSubmission $record): string => $record->message ?? '—'),
                ]),

            Section::make('Triage')
                ->columns(2)
                ->schema([
                    Select::make('status')
                        ->options(SubmissionStatus::options())
                        ->required()
                        ->native(false),

                    Textarea::make('admin_notes')
                        ->label('Internal notes')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Context')
                ->collapsed()
                ->columns(3)
                ->schema([
                    Placeholder::make('locale')
                        ->content(fn (ContactSubmission $record): string => $record->locale),

                    Placeholder::make('ip_address')
                        ->label('IP')
                        ->content(fn (ContactSubmission $record): string => $record->ip_address ?? '—'),

                    Placeholder::make('created_at')
                        ->label('Received')
                        ->content(fn (ContactSubmission $record): string => $record->created_at?->format('M j, Y H:i') ?? '—'),

                    Placeholder::make('referrer')
                        ->columnSpanFull()
                        ->content(fn (ContactSubmission $record): string => $record->referrer ?? '—'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight(fn (ContactSubmission $record): string => $record->status === SubmissionStatus::New
                        ? 'bold'
                        : 'normal'),

                Tables\Columns\TextColumn::make('brand_name')
                    ->label('Brand')
                    ->searchable()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')->badge(),

                Tables\Columns\TextColumn::make('locale')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(SubmissionStatus::options()),

                Tables\Filters\SelectFilter::make('locale')
                    ->options(fn (): array => collect(config('locales.supported'))
                        ->mapWithKeys(fn (array $c, string $code): array => [$code => $c['name']])
                        ->all()),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        // Submissions arrive from the public form only.
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
