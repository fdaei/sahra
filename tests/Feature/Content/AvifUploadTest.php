<?php

declare(strict_types=1);

use App\Enums\PublicationStatus;
use App\Enums\SectionType;
use App\Filament\Resources\MediaResource;
use App\Filament\Resources\MediaResource\Pages\CreateMedia;
use App\Filament\Resources\ServiceResource\Pages\EditService;
use App\Filament\Support\ImageUpload;
use App\Models\Media;
use App\Models\Page;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Livewire;
use Symfony\Component\DomCrawler\Crawler;

it('accepts and previews AVIF images in the media library and image fields', function (): void {
    Storage::fake('local');
    Storage::disk('local')->put('livewire-tmp/image.avif', base64_decode(
        'AAAAIGZ0eXBhdmlmAAAAAGF2aWZtaWYxbWlhZk1BMUIAAADrbWV0YQAAAAAAAAAhaGRscgAAAAAAAAAAcGljdAAAAAAAAAAAAAAAAAAAAAAOcGl0bQAAAAAAAQAAAB5pbG9jAAAAAEQAAAEAAQAAAAEAAAETAAAAJAAAAChpaW5mAAAAAAABAAAAGmluZmUCAAAAAAEAAGF2MDFDb2xvcgAAAABqaXBycAAAAEtpcGNvAAAAFGlzcGUAAAAAAAAAEAAAAAgAAAAQcGl4aQAAAAADCAgIAAAADGF2MUOBAAwAAAAAE2NvbHJuY2x4AAEADQABgAAAABdpcG1hAAAAAAAAAAEAAQQBAoMEAAAALG1kYXQSAAoIGAy/tEBDQGEyFheHh4YhhJJJJlAAAADLqPQawNFa5xg='
    ));
    $file = new TemporaryUploadedFile('image.avif', 'local');

    expect($file->getMimeType())->toBe('image/avif')
        ->and($file->isPreviewable())->toBeTrue()
        ->and(Media::allMimes())->toContain('image/avif')
        ->and(ImageUpload::make('image', 'Image')->getAcceptedFileTypes())->toContain('image/avif')
        ->and(ImageUpload::logo('logo', 'Logo')->getAcceptedFileTypes())->toContain('image/avif');
});

it('keeps the exact uploaded bytes and filename when using an original from the library', function (): void {
    $this->seed(RolePermissionSeeder::class);
    $admin = User::factory()->create()->assignRole('admin');
    $disk = Storage::fake('public');
    $filename = 'طرح اصلی #1-400w.PNG';
    $bytes = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9ZQmcAAAAASUVORK5CYII=');

    for ($upload = 0; $upload < 2; $upload++) {
        Livewire::actingAs($admin)->test(CreateMedia::class)
            ->set('data.path', UploadedFile::fake()->createWithContent($filename, $bytes))
            ->call('create')
            ->assertHasNoFormErrors();
    }

    $files = Media::query()->where('name', $filename)->orderBy('id')->get();
    expect($files)->toHaveCount(2)
        ->and($files[0]->path)->not->toBe($files[1]->path);

    $media = $files[0];
    expect(basename($media->path))->toBe($filename)
        ->and($media->size)->toBe(strlen($bytes))
        ->and($media->width)->toBe(1)
        ->and($media->height)->toBe(1)
        ->and($disk->get($media->path))->toBe($bytes);
    $this->actingAs($admin)->get(MediaResource::getUrl())->assertOk()
        ->assertSee($filename)
        ->assertSee('src="'.$media->url().'"', false);

    Page::factory()->create(['key' => 'services'])->setTranslations(['en' => ['title' => 'Services']]);
    $home = Page::factory()->create(['key' => 'home']);
    $home->setTranslations(['en' => ['title' => 'Home']]);
    $home->sections()->create(['type' => SectionType::ServicesCloud, 'is_visible' => true]);
    $service = Service::query()->create([
        'status' => PublicationStatus::Published,
        'published_at' => now(),
        'show_on_home' => true,
        'home_orbit_group' => 'active',
        'show_on_services_page' => true,
    ]);
    $service->setTranslations(['en' => ['title' => 'Branding', 'slug' => 'branding', 'image_alt' => 'Original photo']]);

    Livewire::actingAs($admin)->test(EditService::class, ['record' => $service->getKey()])
        ->callFormComponentAction('image_path', 'fromLibrary', ['media' => $media->getKey()])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($service->refresh()->image_path)->toBe($media->path)
        ->and($disk->allFiles())->toHaveCount(2)
        ->and($disk->get($media->path))->toBe($bytes);
    $this->get('/en/services')->assertOk()
        ->assertSee('src="'.$media->url().'"', false)
        ->assertDontSee('srcset=', false);
    $homeHtml = new Crawler($this->get('/en')->assertOk()->getContent());
    $previews = $homeHtml->filter('.service-card img');
    expect($previews)->toHaveCount(1)
        ->and($previews->attr('src'))->toBe($media->url());
});
