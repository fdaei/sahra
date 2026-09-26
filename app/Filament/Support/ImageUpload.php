<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Services\MediaTransformer;
use Filament\Forms\Components\FileUpload;

/**
 * The single image-upload field used by every Filament resource.
 *
 * Resizing happens in the browser, twice over:
 *
 * 1. Automatically — FilePond's transform plugin crops to the context's design
 *    ratio and scales down to the target below, so dropping a 12 MP phone photo
 *    into any field yields a web-sized file.
 * 2. By hand — `imageEditor()` opens Cropper.js, where the editor chooses the
 *    crop, rotates and flips. Filament renders that editor's output at exactly
 *    `imageResizeTargetWidth` × `imageResizeTargetHeight` and derives the crop
 *    box's shape from the same pair, so both routes store the same pixel
 *    dimensions — which is why the viewport is never set here by hand.
 *
 * Both run client-side, and deliberately so: the file is shrunk before it ever
 * leaves the browser, which spends the editor's upload bandwidth once instead of
 * on a 12 MP original, and it leaves one code path — not a browser and a server
 * disagreeing — deciding what dimensions get stored.
 *
 * Production has `gd` and `imagick`, so server-side post-processing (thumbnails,
 * WebP derivatives) is available if it is ever wanted. The local dev box has
 * neither, so nothing here may depend on them.
 *
 * Targets come from `MediaTransformer::DIMENSIONS` — the same table the
 * frontend's width/height attributes are built from — doubled for retina and
 * clamped, so an upload can never be smaller than the design needs nor
 * pointlessly larger.
 */
final class ImageUpload
{
    /** Store at twice the design size so the image stays sharp on retina. */
    private const RETINA_SCALE = 2;

    /** Never store an edge below this — a 48 px avatar still deserves detail. */
    private const MIN_EDGE = 640;

    /** …nor above it: page heroes would otherwise land at 2880 px. */
    private const MAX_EDGE = 2400;

    /**
     * Largest original a browser will accept, in KB. The file is resized before
     * upload, so this bounds what the editor may *pick*, not what is stored.
     */
    private const MAX_ORIGINAL_KB = 12288;

    private const RASTER_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    /**
     * A raster image locked to one context's crop ratio and resize target.
     *
     * @param  string  $context  a key of MediaTransformer::DIMENSIONS
     */
    public static function make(
        string $name,
        string $label,
        string $context,
        string $directory = 'uploads',
    ): FileUpload {
        [$width, $height] = MediaTransformer::dimensions($context);
        [$targetWidth, $targetHeight] = self::target($width, $height);

        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->acceptedFileTypes(self::RASTER_TYPES)
            ->maxSize(self::MAX_ORIGINAL_KB)
            ->disk('public')
            ->directory($directory)
            ->imageEditor()
            ->imageCropAspectRatio("{$width}:{$height}")
            ->imageResizeMode('cover')
            ->imageResizeTargetWidth((string) $targetWidth)
            ->imageResizeTargetHeight((string) $targetHeight)
            // A source smaller than the target is left alone rather than
            // stretched — better a crisp small image than a blurred big one.
            ->imageResizeUpscale(false)
            ->openable()
            ->downloadable()
            ->helperText(self::helperText($targetWidth, $targetHeight));
    }

    /**
     * Same, but circular: for avatars.
     *
     * `avatar()` is a bundle of presets that includes a 500×500 target of its
     * own, so the context's target is re-applied after it — otherwise every
     * avatar would silently ignore its design size.
     */
    public static function avatar(
        string $name,
        string $label,
        string $context,
        string $directory = 'uploads',
    ): FileUpload {
        [$width, $height] = MediaTransformer::dimensions($context);
        [$targetWidth, $targetHeight] = self::target($width, $height);

        return self::make($name, $label, $context, $directory)
            ->avatar()
            ->circleCropper()
            ->imageResizeTargetWidth((string) $targetWidth)
            ->imageResizeTargetHeight((string) $targetHeight)
            ->imageResizeUpscale(false);
    }

    /**
     * A logo, which may be an SVG.
     *
     * No crop ratio and no resize target, which is what leaves FilePond's
     * transform plugin switched off: it would rasterise a vector to canvas and
     * throw away the reason for uploading an SVG. Cropper.js is off for the
     * same reason. Raster logos are therefore stored as supplied — hence the
     * tighter size ceiling.
     */
    public static function logo(
        string $name,
        string $label,
        string $directory = 'uploads',
    ): FileUpload {
        [$width, $height] = MediaTransformer::dimensions('client');

        return FileUpload::make($name)
            ->label($label)
            ->disk('public')
            ->directory($directory)
            ->acceptedFileTypes(['image/svg+xml', ...self::RASTER_TYPES])
            ->maxSize(512)
            ->imagePreviewHeight('80')
            ->openable()
            ->downloadable()
            ->helperText(
                'SVG preferred — it stays sharp at any size and is not resized on upload. '
                ."A raster logo is stored as supplied, so export it at around {$width}×{$height} "
                .'(or twice that) and keep it under 512 KB.',
            );
    }

    /**
     * Design size → stored size: doubled for retina, then clamped so no edge
     * falls below MIN_EDGE or rises above MAX_EDGE. Scaling both edges by one
     * factor is what preserves the ratio the crop box enforces.
     *
     * @return array{int, int}
     */
    private static function target(int $width, int $height): array
    {
        $scale = (float) self::RETINA_SCALE;
        $longest = max($width, $height) * $scale;

        if ($longest < self::MIN_EDGE) {
            $scale *= self::MIN_EDGE / $longest;
        } elseif ($longest > self::MAX_EDGE) {
            $scale *= self::MAX_EDGE / $longest;
        }

        return [(int) round($width * $scale), (int) round($height * $scale)];
    }

    private static function helperText(int $width, int $height): string
    {
        return "Any size — cropped and resized in your browser to {$width}×{$height} before upload. "
            .'Use the pencil to choose the crop yourself; JPEG, PNG or WebP, up to 12 MB.';
    }
}
