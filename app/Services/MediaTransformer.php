<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;

/**
 * Provides the original image URL and layout dimensions for the public views.
 */
final class MediaTransformer
{
    /**
     * Layout dimensions per usage context, taken from the design.
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
     * Layout width and height for a context, falling back to the generic
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

        // No alt on the field → the alt written for this file in the Media library.
        if ($alt === null || trim($alt) === '') {
            $alt = Media::altFor($path);
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
     * Public URL for a stored path or an existing external URL.
     */
    public static function url(string $path): string
    {
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        return Media::publicUrl($path);
    }
}
