<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

final class ImagePreview
{
    public const LOGO_SIZE = 256;

    public const CARD_SIZE = 1024;

    public static function url(?string $path, int $maxSize): ?string
    {
        $files = self::paths($path, $maxSize);

        return $files !== null && is_file($files['target']) ? Media::publicUrl($files['relative']) : null;
    }

    public static function generate(string $path, int $maxSize): bool
    {
        $files = self::paths($path, $maxSize);
        if ($files === null || is_file($files['target']) || $files['size'] > 12 * 1024 * 1024) {
            return false;
        }

        $dimensions = @getimagesize($files['source']);
        if ($dimensions === false || ! in_array($dimensions[2], [IMAGETYPE_PNG, IMAGETYPE_WEBP], true)
            || $dimensions[0] * $dimensions[1] > 8_000_000) {
            return false;
        }

        $bytes = @file_get_contents($files['source']);
        if ($bytes === false || str_contains($bytes, 'acTL') || str_contains($bytes, 'ANIM')) {
            return false;
        }

        $source = @imagecreatefromstring($bytes);
        if ($source === false) {
            return false;
        }

        [$width, $height] = $dimensions;
        $scale = min(1, $maxSize / max($width, $height));
        $preview = imagescale($source, max(1, (int) round($width * $scale)), max(1, (int) round($height * $scale)));
        if ($preview === false) {
            return false;
        }
        imagesavealpha($preview, true);

        $directory = dirname($files['target']);
        if (! is_dir($directory) && ! @mkdir($directory, 0755, true) && ! is_dir($directory)) {
            return false;
        }
        $temporary = tempnam($directory, '.preview-');
        if ($temporary === false) {
            return false;
        }

        try {
            if (! imagewebp($preview, $temporary, 84) || filesize($temporary) <= 0 || filesize($temporary) >= $files['size'] * 0.8) {
                return false;
            }

            return chmod($temporary, 0644) && rename($temporary, $files['target']);
        } finally {
            if (is_file($temporary)) {
                unlink($temporary);
            }
        }
    }

    /** @return array{source: string, target: string, relative: string, size: int}|null */
    private static function paths(?string $path, int $maxSize): ?array
    {
        if ($path === null || ! preg_match('~\A[^/].*\.(?:png|webp)\z~i', $path)
            || preg_match('~(?:^|/)\.{1,2}(?:/|$)|[\x00\\\\:]~', $path)
            || config('filesystems.disks.public.driver') !== 'local') {
            return null;
        }

        $disk = Storage::disk(Media::DISK);
        $source = $disk->path($path);
        $stat = @stat($source);
        if ($stat === false || ! is_file($source)) {
            return null;
        }

        $key = hash('sha256', $path.'|'.$stat['mtime'].'|'.$stat['size']);
        $relative = "previews/{$maxSize}/{$key}.webp";

        return ['source' => $source, 'target' => $disk->path($relative), 'relative' => $relative, 'size' => $stat['size']];
    }
}
