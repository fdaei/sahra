<?php

declare(strict_types=1);

use App\Filament\Support\ImageUpload;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

it('accepts and previews AVIF images in the media library and image fields', function (): void {
    Storage::fake('local');
    Storage::disk('local')->put('livewire-tmp/image.avif', base64_decode(
        'AAAAIGZ0eXBhdmlmAAAAAGF2aWZtaWYxbWlhZk1BMUIAAADrbWV0YQAAAAAAAAAhaGRscgAAAAAAAAAAcGljdAAAAAAAAAAAAAAAAAAAAAAOcGl0bQAAAAAAAQAAAB5pbG9jAAAAAEQAAAEAAQAAAAEAAAETAAAAJAAAAChpaW5mAAAAAAABAAAAGmluZmUCAAAAAAEAAGF2MDFDb2xvcgAAAABqaXBycAAAAEtpcGNvAAAAFGlzcGUAAAAAAAAAEAAAAAgAAAAQcGl4aQAAAAADCAgIAAAADGF2MUOBAAwAAAAAE2NvbHJuY2x4AAEADQABgAAAABdpcG1hAAAAAAAAAAEAAQQBAoMEAAAALG1kYXQSAAoIGAy/tEBDQGEyFheHh4YhhJJJJlAAAADLqPQawNFa5xg='
    ));
    $file = new TemporaryUploadedFile('image.avif', 'local');

    expect($file->getMimeType())->toBe('image/avif')
        ->and($file->isPreviewable())->toBeTrue()
        ->and(Media::allMimes())->toContain('image/avif')
        ->and(ImageUpload::make('image', 'Image', 'section')->getAcceptedFileTypes())->toContain('image/avif')
        ->and(ImageUpload::logo('logo', 'Logo')->getAcceptedFileTypes())->toContain('image/avif');
});
