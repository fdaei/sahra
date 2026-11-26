<?php

declare(strict_types=1);

use App\Services\MediaTransformer;
use Illuminate\Support\Facades\Storage;

it('uses the original image for every layout and redirects old variant URLs', function (): void {
    Storage::fake('public');
    $disk = Storage::disk('public');
    $disk->put('cover.png', 'original');
    $disk->put('cover-400w.jpg', 'old variant');
    foreach (array_keys(MediaTransformer::DIMENSIONS) as $context) {
        $image = MediaTransformer::make('cover.png', 'Cover', $context);
        expect($image['src'])->toBe('/storage/cover.png')
            ->and($image)->not->toHaveKey('srcset');
    }
    $this->get('/media/jpeg/400/cover.png')->assertMovedPermanently()->assertRedirect('/storage/cover.png');
    $this->get('/media/webp/736/cover.png')->assertMovedPermanently()->assertRedirect('/storage/cover.png');
    $this->get('/media/jpeg/448/cover.png')->assertNotFound();
    $this->get('/media/jpeg/400/missing.png')->assertNotFound();
    expect($disk->get('cover.png'))->toBe('original')
        ->and($disk->allFiles())->toBe(['cover-400w.jpg', 'cover.png']);
});

it('preserves SVG and external image sources', function (): void {
    expect(MediaTransformer::make('clients/logo.svg')['src'])->toBe('/storage/clients/logo.svg')
        ->and(MediaTransformer::make('https://cdn.example/image.jpg')['src'])->toBe('https://cdn.example/image.jpg');
});
