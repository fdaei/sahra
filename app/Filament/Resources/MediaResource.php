<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\MediaResource\Pages;
use App\Filament\Support\OriginalUpload;
use App\Filament\Support\TranslatableForm;
use App\Models\Media;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Number;

/**
 * Media library — every image, video, audio file and document in one place,
 * each with per-locale SEO metadata (title, alt, caption, description) and a
 * schema.org type. Files are always uploaded, never linked by URL.
 *
 * The library alt is the site-wide fallback for any image field left without
 * one, and content image fields can reuse a file via "Choose from library"
 * (App\Filament\Support\ImageUpload).
 */
final class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Website content';

    protected static ?string $navigationLabel = 'Media library';

    protected static ?int $navigationSort = 99;

    /** Largest upload, in KB (256 MB — production's PHP limit). */
    public const MAX_KB = 262144;

    public static function form(Form $form): Form
    {
        return $form->columns(3)->schema([
            Section::make('File')
                ->columnSpan(fn (string $operation): int => $operation === 'create' ? 3 : 1)
                ->schema([
                    OriginalUpload::make('path', fn (): string => Media::LIBRARY_DIR.'/'.now()->format('Y/m'), Media::allMimes(), self::MAX_KB)
                        ->label('File')
                        ->helperText('The original file is saved with its filename. Image, video, audio, PDF and Office formats are supported.')
                        ->required()
                        ->visibleOn('create'),

                    Placeholder::make('preview')
                        ->hiddenLabel()
                        ->content(fn (?Media $record): HtmlString => self::preview($record))
                        ->visibleOn('edit'),

                    Placeholder::make('info')
                        ->label('Details')
                        ->content(fn (?Media $record): HtmlString => new HtmlString($record === null ? '' : collect([
                            'Type' => Media::TYPES[$record->type] ?? $record->type,
                            'Format' => $record->mime,
                            'Size' => Number::fileSize($record->size),
                            'Dimensions' => $record->width ? "{$record->width}×{$record->height}" : null,
                            'Path' => $record->path,
                        ])->filter()->map(fn (string $v, string $k): string => '<div><strong>'.e($k).':</strong> <span style="word-break:break-all">'.e($v).'</span></div>')->implode('')))
                        ->visibleOn('edit'),

                    TextInput::make('url')
                        ->label('Public URL')
                        ->formatStateUsing(fn (?Media $record): ?string => $record?->url())
                        ->readOnly()
                        ->dehydrated(false)
                        ->suffixAction(\Filament\Forms\Components\Actions\Action::make('open')
                            ->icon('heroicon-o-arrow-top-right-on-square')
                            ->url(fn (?Media $record): ?string => $record?->url())
                            ->openUrlInNewTab())
                        ->visibleOn('edit'),
                ]),

            Section::make('SEO')
                ->description('Search engines read these. Alt is required for accessibility on images; title and description feed the schema.org markup.')
                ->columnSpan(fn (string $operation): int => $operation === 'create' ? 3 : 2)
                ->schema([
                    TranslatableForm::tabs(fn (string $locale): array => [
                        TextInput::make("translations.{$locale}.title")
                            ->label('SEO title')
                            ->helperText('Name of the file in search results and schema (e.g. "Sahra brand workshop, Tehran 2026").')
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.alt")
                            ->label('Alt text')
                            ->helperText('What the image shows, in one sentence. Used wherever this file appears without its own alt.')
                            ->maxLength(300),
                        TextInput::make("translations.{$locale}.caption")
                            ->label('Caption')
                            ->maxLength(500),
                        Textarea::make("translations.{$locale}.description")
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(2000),
                    ], 'SEO metadata'),

                    Section::make('Schema (structured data)')
                        ->columns(2)
                        ->schema([
                            Toggle::make('schema_enabled')
                                ->label('Output schema.org markup')
                                ->default(true)
                                ->live()
                                ->columnSpanFull(),
                            Select::make('schema_type')
                                ->label('Schema type')
                                ->options(Media::SCHEMA_TYPES)
                                ->placeholder('Automatic (from file type)')
                                ->native(false)
                                ->visible(fn (Get $get): bool => (bool) $get('schema_enabled')),
                            TextInput::make('credit')
                                ->label('Credit / copyright holder')
                                ->maxLength(255)
                                ->visible(fn (Get $get): bool => (bool) $get('schema_enabled')),
                            Placeholder::make('schema_preview')
                                ->label('Generated JSON-LD')
                                ->content(fn (?Media $record): HtmlString => new HtmlString($record?->schema() === null ? '—' :
                                    '<pre style="font-size:12px;white-space:pre-wrap;direction:ltr;text-align:left">'.e(json_encode($record->schema(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)).'</pre>'))
                                ->helperText('Updates after saving.')
                                ->visibleOn('edit')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Video')
                        ->columns(2)
                        ->visible(fn (?Media $record): bool => $record?->isVideo() ?? false)
                        ->schema([
                            OriginalUpload::make('poster_path', Media::LIBRARY_DIR.'/posters', Media::MIMES['image'], 5120)
                                ->label('Poster / thumbnail')
                                ->helperText('Shown before playback; required by Google for video rich results.'),
                            TextInput::make('duration')
                                ->label('Duration (seconds)')
                                ->numeric()
                                ->minValue(0),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->contentGrid(['md' => 3, 'xl' => 5])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('thumb')
                        ->defaultImageUrl(fn (Media $record): string => match (true) {
                            $record->isImage() => $record->url(),
                            $record->poster_path !== null => Media::publicUrl($record->poster_path),
                            default => self::typeIcon($record->type),
                        })
                        ->height(160)
                        ->width('100%')
                        ->extraImgAttributes(['class' => 'w-full rounded-lg', 'style' => 'object-fit: contain', 'loading' => 'lazy']),
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->weight('medium')
                        ->wrap()
                        ->tooltip(fn (Media $record): string => $record->path),
                    Tables\Columns\TextColumn::make('type')
                        ->badge()
                        ->formatStateUsing(fn (string $state, Media $record): string => (Media::TYPES[$state] ?? $state)
                            .' · '.Number::fileSize($record->size)
                            .($record->width ? " · {$record->width}×{$record->height}" : '')),
                    Tables\Columns\TextColumn::make('alt_status')
                        ->getStateUsing(fn (Media $record): ?string => $record->isImage() && blank($record->getTranslation('alt')) ? 'No alt text' : null)
                        ->color('danger')
                        ->size('xs'),
                ])->space(2),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(Media::TYPES),
                Tables\Filters\Filter::make('missing_alt')
                    ->label('Images without alt text')
                    ->query(fn (Builder $q): Builder => $q->where('type', 'image')
                        ->whereDoesntHave('translations', fn (Builder $t) => $t->where('locale', app()->getLocale())->whereNotNull('alt')->where('alt', '!=', ''))),
                Tables\Filters\SelectFilter::make('folder')
                    ->options(fn (): array => collect(Storage::disk(Media::DISK)->directories())
                        ->reject(fn (string $d): bool => in_array($d, ['livewire-tmp', 'icons'], true))
                        ->mapWithKeys(fn (string $d): array => [$d => $d])
                        ->all())
                    ->query(fn (Builder $query, array $data): Builder => filled($data['value'] ?? null)
                        ? $query->where('path', 'like', $data['value'].'/%')
                        : $query),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconButton()
                    ->url(fn (Media $record): string => $record->url())
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    // Files uploaded through a content field belong to that record.
                    ->visible(fn (Media $record): bool => $record->isLibraryFile())
                    ->after(fn (Media $record) => self::deleteFiles($record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(fn ($records) => $records
                        ->filter(fn (Media $m): bool => $m->isLibraryFile() && (auth()->user()?->can('delete', $m) ?? false))
                        ->each(function (Media $m): void {
                            self::deleteFiles($m);
                            $m->delete();
                        })),
            ]);
    }

    public static function deleteFiles(Media $media): void
    {
        $disk = Storage::disk(Media::DISK);
        $disk->delete(array_filter([$media->path, $media->poster_path]));
    }

    private static function preview(?Media $record): HtmlString
    {
        if ($record === null) {
            return new HtmlString('');
        }

        $url = e($record->url());
        $style = 'max-width:100%;border-radius:8px';

        return new HtmlString(match ($record->type) {
            'image' => "<img src=\"{$url}\" alt=\"\" style=\"{$style}\">",
            'video' => "<video src=\"{$url}\" controls preload=\"metadata\" style=\"{$style}\"".($record->poster_path ? ' poster="'.e(Media::publicUrl($record->poster_path)).'"' : '').'></video>',
            'audio' => "<audio src=\"{$url}\" controls style=\"width:100%\"></audio>",
            default => "<a href=\"{$url}\" target=\"_blank\" rel=\"noopener\" style=\"text-decoration:underline\">".e($record->name).'</a>',
        });
    }

    private static function typeIcon(string $type): string
    {
        $label = strtoupper(Media::TYPES[$type] ?? $type);

        return 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="320" height="160"><rect width="100%" height="100%" fill="#f3f4f6"/><text x="50%" y="50%" fill="#6b7280" font-family="sans-serif" font-size="20" text-anchor="middle" dominant-baseline="middle">'.$label.'</text></svg>');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('translations');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
