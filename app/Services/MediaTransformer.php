<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;

/**
 * Converts a stored image path into the MediaImage shape the frontend expects
 * (resources/js/types/index.ts).
 *
 * Dimensions come from the Figma frames — see docs/ASSET-MANIFEST.md. They are
 * emitted as width/height attributes so the browser reserves space before the
 * image loads, which is what keeps the scroll animations from causing layout
 * shift (Phase 6 requirement: no CLS).
 */
final class MediaTransformer
{
    /**
     * Intrinsic dimensions per usage context, taken from the design.
     *
     * Also drives the admin uploader: `App\Filament\Support\ImageUpload`
     * reads these to fix each field's crop ratio and resize target, so what an
     * editor uploads matches the width/height emitted here and no image is
     * stored larger than the design asks for.
     *
     * @var array<string, array{int, int}>
     */
    public const DIMENSIONS = [
        'project.cover' => [448, 448],      // 1362:7211 square card
        'project.banner' => [1203, 624],     // 1323:7605 case-study banner
        'project.showcase' => [400, 500],    // content showcase item
        'project.beforeafter' => [560, 360],
        'service' => [604, 786],             // 1323:7224 portrait
        'post.cover' => [736, 414],          // 1353:7935 listing card
        'post.hero' => [1248, 624],          // 1352:7391 article hero
        'team' => [294, 294],                // 992:2644 member card
        'testimonial' => [48, 48],           // 1419:9251 avatar
        'client' => [120, 40],               // 1419:9205 logo
        'page.hero' => [1440, 904],          // 1419:9193
        'page.about' => [420, 420],          // 951:3598
        'section' => [1248, 624],            // generic section image
        'seo.share' => [1200, 630],          // Open Graph card, not a Figma frame
    ];

    /**
     * Intrinsic width/height for a context, falling back to the generic
     * section frame for anything unrecognised.
     *
     * @return array{int, int}
     */
    public static function dimensions(string $context): array
    {
        return self::DIMENSIONS[$context] ?? self::DIMENSIONS['section'];
    }

    /**
     * @return array{src: string, alt: string, width: int, height: int}|null
     */
    public static function make(
        ?string $path,
        ?string $alt = null,
        string $context = 'section',
    ): ?array {
        if ($path === null || $path === '') {
            return null;
        }

        [$width, $height] = self::dimensions($context);

        return [
            'src' => self::url($path),
            'alt' => $alt ?? '',
            'width' => $width,
            'height' => $height,
        ];
    }

    /**
     * Absolute URL for a stored path. Already-absolute values (a CDN URL typed
     * into admin) are returned untouched.
     */
    public static function url(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
