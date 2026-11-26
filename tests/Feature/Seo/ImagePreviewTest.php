<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use App\Models\Service;
use App\Services\ImagePreview;
use App\Services\MediaTransformer;
use Illuminate\Support\Facades\Storage;

it('generates a small transparent preview without changing the original', function (): void {
    if (! function_exists('imagewebp')) {
        $this->markTestSkipped('GD with WebP support is required.');
    }

    $disk = Storage::fake('public');
    $path = 'clients/logo.png';
    $disk->makeDirectory('clients');
    $image = imagecreatetruecolor(512, 256);
    imagealphablending($image, false);
    imagesavealpha($image, true);
    imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
    imagefilledrectangle($image, 64, 64, 448, 192, imagecolorallocate($image, 189, 147, 59));
    imagepng($image, $disk->path($path), 0);
    $original = $disk->get($path);

    expect(ImagePreview::url($path, ImagePreview::LOGO_SIZE))->toBeNull()
        ->and(ImagePreview::generate($path, ImagePreview::LOGO_SIZE))->toBeTrue()
        ->and(ImagePreview::generate($path, ImagePreview::LOGO_SIZE))->toBeFalse();

    $preview = ImagePreview::url($path, ImagePreview::LOGO_SIZE);
    expect($preview)->toStartWith('/storage/previews/256/');
    $previewPath = $disk->path(substr($preview, strlen('/storage/')));
    expect(getimagesize($previewPath))->toMatchArray([256, 128, IMAGETYPE_WEBP])
        ->and(imagecolorat(imagecreatefromwebp($previewPath), 0, 0) >> 24)->toBe(127)
        ->and($disk->get($path))->toBe($original)
        ->and(MediaTransformer::make($path)['src'])->toBe('/storage/'.$path);

    Service::query()->create(['status' => PublicationStatus::Published, 'image_path' => $path]);
    $this->artisan('sahra:generate-image-previews')->assertSuccessful();
    expect(ImagePreview::url($path, ImagePreview::CARD_SIZE))->toStartWith('/storage/previews/1024/');

    imagepng($image, $disk->path($path), 9);
    clearstatcache(true, $disk->path($path));
    expect(ImagePreview::url($path, ImagePreview::LOGO_SIZE))->toBeNull();
});
