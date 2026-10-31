<?php

declare(strict_types=1);

use App\Services\MediaTransformer;
use Illuminate\Support\Facades\Storage;

it('serves PHP image responses at every generated fallback width', function (): void {
    Storage::fake('public');
    Storage::disk('public')->put('cover.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9ZQmcAAAAASUVORK5CYII='));
    foreach (array_keys(MediaTransformer::DIMENSIONS) as $context) {
        $image = MediaTransformer::make('cover.png', 'Cover', $context);
        $this->get($image['src'])->assertOk();
    }
    $this->get('/media/jpeg/448/cover.png')->assertNotFound();
    $this->get('/media/jpeg/400/missing.png')->assertNotFound();
});

it('preserves SVG and external image sources', function (): void {
    expect(MediaTransformer::make('clients/logo.svg')['src'])->toBe('/storage/clients/logo.svg')
        ->and(MediaTransformer::make('https://cdn.example/image.jpg')['src'])->toBe('https://cdn.example/image.jpg');
});
