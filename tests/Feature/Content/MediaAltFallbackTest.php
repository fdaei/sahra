<?php

declare(strict_types=1);

use App\Models\Media;
use App\Services\MediaTransformer;

it('falls back to the library alt when a field has none', function (): void {
    $media = Media::create(['path' => 'projects/x.svg', 'name' => 'x.svg', 'mime' => 'image/svg+xml', 'type' => 'image', 'size' => 1]);
    $media->setTranslations(['en' => ['alt' => 'Library alt']]);
    app()->setLocale('en');

    expect(MediaTransformer::make('projects/x.svg', null)['alt'])->toBe('Library alt')
        ->and(MediaTransformer::make('projects/x.svg', 'Own alt')['alt'])->toBe('Own alt');
});

it('builds an ImageObject schema node', function (): void {
    $media = Media::create(['path' => 'library/a.jpg', 'name' => 'a.jpg', 'mime' => 'image/jpeg', 'type' => 'image', 'size' => 10, 'width' => 4, 'height' => 3]);
    $media->setTranslations(['en' => ['title' => 'Title', 'alt' => 'Alt']]);

    $node = $media->fresh('translations')->schema('en');

    expect($node['@type'])->toBe('ImageObject')->and($node['name'])->toBe('Title')->and($node['width'])->toBe('4');
});
