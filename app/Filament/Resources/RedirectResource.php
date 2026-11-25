<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use App\Rules\RedirectDestination;
use Filament\Forms\Get;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use App\Filament\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * URL redirects, so slugs can change without breaking inbound links.
 */
final class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'SEO';

    protected static ?string $navigationLabel = 'Old URL redirects';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    Select::make('match_type')
                        ->label('Match type')->options(['exact' => __('Exact'), 'regex' => __('Regular expression')])
                        ->default('exact')->required()->live()->native(false),
                    TextInput::make('source_path')
                        ->label('From')
                        ->required()
                        ->maxLength(500)
                        ->mutateStateForValidationUsing(fn (?string $state, Get $get): string => $get('match_type') === 'regex' ? trim((string) $state) : Redirect::normalize($state ?? ''))
                        ->dehydrateStateUsing(fn (?string $state, Get $get): string => $get('match_type') === 'regex' ? trim((string) $state) : Redirect::normalize($state ?? ''))
                        ->unique(ignoreRecord: true)
                        ->rules([fn (Get $get): \Closure => function (string $attribute, mixed $value, \Closure $fail) use ($get): void {
                            if ($get('match_type') === 'regex' && (! is_string($value) || \App\Services\Redirects\RegexRedirect::pattern($value) === null)) {
                                $fail(__('Enter a valid regular expression.'));
                            }
                        }])
                        ->helperText('Exact path or a regular expression without delimiters, for example en/old/(.*).'),

                    TextInput::make('destination_path')
                        ->label('To')
                        ->required(fn (Get $get): bool => ! in_array((int) $get('status_code'), Redirect::GONE, true))
                        ->hidden(fn (Get $get): bool => in_array((int) $get('status_code'), Redirect::GONE, true))
                        ->maxLength(500)
                        ->dehydrateStateUsing(fn (?string $state): string => trim($state ?? ''))
                        ->rules([fn (Get $get): RedirectDestination => new RedirectDestination((string) $get('source_path'))])
                        ->prefix(config('app.url').'/'),

                    Select::make('status_code')
                        ->options(\App\Models\Redirect::STATUSES)
                        ->in(array_keys(Redirect::STATUSES))
                        ->default(301)
                        ->required()
                        ->live()
                        ->native(false),

                    TextInput::make('notes')->label('Notes')->maxLength(500),

                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('source_path')
                    ->label('From')
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('destination_path')
                    ->label('To')
                    ->searchable()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status_code')->badge(),
                Tables\Columns\TextColumn::make('match_type')->label('Match type')->badge(),
                Tables\Columns\TextColumn::make('origin')->label('Origin')->badge()->toggleable(),

                Tables\Columns\TextColumn::make('hits')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_hit_at')
                    ->dateTime('M j, Y')
                    ->placeholder('Never')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('status_code')->label('Status')->options(Redirect::STATUSES),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
