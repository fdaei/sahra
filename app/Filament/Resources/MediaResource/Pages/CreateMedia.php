<?php

declare(strict_types=1);

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Concerns\HandlesTranslations;
use App\Filament\Resources\MediaResource;
use App\Models\Media;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

final class CreateMedia extends CreateRecord
{
    use HandlesTranslations {
        mutateFormDataBeforeCreate as splitTranslations;
    }

    protected static string $resource = MediaResource::class;

    /**
     * Fill the technical columns (mime, type, size, dimensions) from the
     * stored file — the editor only supplies the file and its metadata.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->splitTranslations($data);
        $path = (string) $data['path'];
        $disk = Storage::disk(Media::DISK);
        $mime = (string) ($disk->mimeType($path) ?: 'application/octet-stream');
        $type = Media::typeFor($mime, $path);
        $info = $type === 'image' && ! str_ends_with(strtolower($path), '.svg') ? @getimagesize($disk->path($path)) : false;

        return [
            ...$data,
            'name' => basename($path),
            'mime' => $mime,
            'type' => $type,
            'size' => (int) $disk->size($path),
            'width' => $info ? $info[0] : null,
            'height' => $info ? $info[1] : null,
            'uploaded_by' => auth()->id(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Straight to the edit screen so video poster/schema can be filled in.
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
