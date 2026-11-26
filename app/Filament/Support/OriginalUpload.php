<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Models\Media;
use Closure;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

final class OriginalUpload
{
    /** @param list<string> $types */
    public static function make(string $name, string|Closure $directory, array $types, int $maxSize): FileUpload
    {
        return FileUpload::make($name)
            ->disk(Media::DISK)
            ->directory($directory)
            ->acceptedFileTypes($types)
            ->maxSize($maxSize)
            ->orientImagesFromExif(false)
            ->getUploadedFileUsing(static function (FileUpload $component, string $file): ?array {
                $disk = $component->getDisk();

                return $disk->exists($file) ? [
                    'name' => basename($file),
                    'size' => $disk->size($file),
                    'type' => $disk->mimeType($file),
                    'url' => Media::publicUrl($file),
                ] : null;
            })
            ->saveUploadedFileUsing(static function (FileUpload $component, TemporaryUploadedFile $file): string {
                $filename = $file->getClientOriginalName();
                $type = Media::typeFor($file->getMimeType());
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (! Media::supportsExtension($extension, $type)
                    || str_starts_with($filename, '.')
                    || str_contains($filename, '/') || str_contains($filename, '\\')
                    || preg_match('/\p{C}/u', $filename) !== 0
                    || preg_match('/\.(?:php\d*|pht(?:ml)?|phar|phps|shtml?|cgi|fcgi|pl|py|sh)\./i', $filename)
                ) {
                    throw ValidationException::withMessages([$component->getStatePath() => 'Choose a file with a supported filename and extension.']);
                }

                // A separate directory lets uploads with the same name coexist.
                $path = trim($component->getDirectory(), '/').'/'.Str::ulid().'/'.$filename;

                if (! $component->getDisk()->put($path, $file->readStream())) {
                    throw ValidationException::withMessages([$component->getStatePath() => 'The original file could not be saved.']);
                }

                return $path;
            });
    }
}
