<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Models\Media;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;

final class ImageUpload
{
    public static function make(string $name, string $label, string $directory = 'uploads'): FileUpload
    {
        return OriginalUpload::make($name, $directory, Media::MIMES['image'], 12288)
            ->label($label)
            ->openable()
            ->downloadable()
            ->hintAction(self::libraryPicker())
            ->helperText('The original file is saved as uploaded. Maximum upload size is 12 MB.');
    }

    public static function logo(string $name, string $label, string $directory = 'uploads'): FileUpload
    {
        return OriginalUpload::make($name, $directory, Media::MIMES['image'], 512)
            ->label($label)
            ->imagePreviewHeight('80')
            ->openable()
            ->downloadable()
            ->helperText('The original file is saved as uploaded. Maximum upload size is 512 KB.');
    }

    private static function libraryPicker(): Action
    {
        return Action::make('fromLibrary')
            ->label('Choose from library')
            ->icon('heroicon-o-photo')
            ->modalHeading('Media library')
            ->modalSubmitActionLabel('Use image')
            ->form([
                Select::make('media')
                    ->hiddenLabel()
                    ->required()
                    ->searchable()
                    ->allowHtml()
                    ->getSearchResultsUsing(fn (string $search): array => self::pickerOptions($search))
                    ->options(function (): array {
                        Media::sync();

                        return self::pickerOptions();
                    }),
            ])
            ->action(function (array $data, FileUpload $component): void {
                $media = Media::query()->where('type', 'image')->findOrFail($data['media']);

                $component->state([(string) Str::uuid() => $media->path]);
            });
    }

    /** @return array<int, string> */
    private static function pickerOptions(string $search = ''): array
    {
        return Media::query()
            ->where('type', 'image')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->latest()
            ->limit(60)
            ->get()
            ->mapWithKeys(fn (Media $media): array => [$media->getKey() => sprintf(
                '<span style="display:flex;gap:.75rem;align-items:center"><img src="%s" alt="" loading="lazy" style="width:56px;height:56px;object-fit:contain"><span>%s</span></span>',
                e($media->url()),
                e($media->name),
            )])
            ->all();
    }
}
