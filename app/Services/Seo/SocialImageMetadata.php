<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Models\Media;

final class SocialImageMetadata
{
    /** @return array{alt: ?string, width: ?int, height: ?int, mime: ?string} */
    public static function for(?string $path, ?string $preferredAlt, string $locale): array
    {
        $preferredAlt = trim((string) $preferredAlt);
        $media = null;
        if (filled($path) && ! preg_match('~^https?://~i', $path)) {
            $path = ltrim($path, '/');
            $media = Media::query()->where('path', $path)->where('type', 'image')->first(['path', 'width', 'height', 'mime']);
        }
        $alt = $preferredAlt !== '' ? $preferredAlt : ($media ? Media::altFor($path, $locale) : null);
        return [
            'alt' => filled($alt) ? $alt : null,
            'width' => $media?->width ?: null,
            'height' => $media?->height ?: null,
            'mime' => $media?->mime ?: null,
        ];
    }
}
