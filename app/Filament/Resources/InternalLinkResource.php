<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\InternalLinkResource\Pages;
use App\Models\InternalLink;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

final class InternalLinkResource extends Resource
{
    protected static ?string $model = InternalLink::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?string $navigationLabel = 'Automatic internal links';
    protected static ?int $navigationSort = 5;

    public static function canViewAny(): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function canCreate(): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function canEdit($record): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function canDelete($record): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function canDeleteAny(): bool { return auth()->user()?->isAdmin() ?? false; }

    public static function form(Form $form): Form
    {
        $locales = collect(config('locales.supported'))->map(fn (array $item): string => $item['native'])->all();
        return $form->schema([
            Section::make('Keyword link')->description('Links matching article text when shown; stored articles are not changed.')
                ->columns(2)->schema([
                    TextInput::make('keyword')->label('Keyword')->required()->maxLength(190)
                        ->unique(ignoreRecord: true, modifyRuleUsing: fn (Unique $rule, Get $get) => $rule->where('locale', $get('locale'))),
                    TextInput::make('url')->label('Internal path')->required()->maxLength(500)
                        ->rules([fn (): \Closure => function (string $attribute, mixed $value, \Closure $fail): void {
                            if (! \App\Support\InternalPath::valid($value)) {
                                $fail(__('Use a valid internal path beginning with /'));
                            }
                        }])
                        ->helperText('Use a site path, for example /en/services.')->placeholder('/en/services'),
                    Select::make('locale')->label('Language')->options($locales)->default(config('locales.default'))->required()->native(false),
                    TextInput::make('max_per_page')->label('Maximum links per article')->numeric()->integer()->minValue(1)->maxValue(10)->default(1)->required(),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('keyword')->columns([
            Tables\Columns\TextColumn::make('keyword')->label('Keyword')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('url')->label('Destination')->limit(50),
            Tables\Columns\TextColumn::make('locale')->label('Language')->badge(),
            Tables\Columns\TextColumn::make('max_per_page')->label('Maximum'),
            Tables\Columns\ToggleColumn::make('is_active')->label('Active'),
        ])->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListInternalLinks::route('/'), 'create' => Pages\CreateInternalLink::route('/create'), 'edit' => Pages\EditInternalLink::route('/{record}/edit')];
    }
}
