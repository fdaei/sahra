<?php

declare(strict_types=1);

/**
 * One-shot deployer: admin image upload + resize.
 * =================================================================
 *
 * Upload this file into public_html, open it in a browser, check the dry-run
 * report, then run it for real. IT DELETES ITSELF once it has applied cleanly.
 *
 *   https://your-site.com/deploy-image-uploads.php?token=TOKEN            (dry run)
 *   https://your-site.com/deploy-image-uploads.php?token=TOKEN&run=1      (apply)
 *
 * READ THIS: while this file sits in public_html, anyone who knows the URL and
 * the token can rewrite application source. That is what it is for, and it is
 * why it self-deletes. If a run fails halfway, DELETE IT BY HAND before walking
 * away — do not leave it there "for next time".
 *
 * What it will not do: touch a file whose contents it does not recognise. Every
 * target is checked against a known-good SHA-256 before and after, so a host
 * that has drifted from the repository is reported and skipped, never
 * clobbered. Every overwritten file is backed up outside the web root first.
 *
 * Nothing here needs composer, npm or a migration: these are plain PHP sources
 * and Filament's uploader assets already ship in public/js/filament.
 */

const TOKEN = 'k7Qv2mXp9sLdR4hTzN8wYbG3';
const PROJECT = 'sahra/marketing';

// ---------------------------------------------------------------- payload ---

/**
 * Two new files, given in full; nine existing files, given as exact
 * search/replace pairs so an unexpected host copy cannot be silently rewritten.
 * 'sha' is what the file must hash to when the deployer is done with it.
 */
$PLAN = [

'app/Filament/Support/ImageUpload.php' => [
    'sha' => '2b7da203f9d8bc74413ae1d0d11799d2d1bcefd7450affb2cd09c9dc7a0b5c92',
    // Earlier versions this deployer itself wrote; safe to replace.
    'prior' => ['f2762fbdfe9da0ae24cce37e93dc2828838aef6eab0ce5de4bb3c090597ffd34'],
    'create' => <<<'EDIT_EOT'
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
EDIT_EOT
],

'app/Services/MediaTransformer.php' => [
    'sha' => '5141cd3ad108f65d75967f7f12aaf1f1cb5289351c0a642c1e3ad56f21ce07ec',
    'edits' => [
        [<<<'EDIT_EOT'
     * @var array<string, array{int, int}>
     */
    private const DIMENSIONS = [
EDIT_EOT
, <<<'EDIT_EOT'
     * Also drives the admin uploader: `App\Filament\Support\ImageUpload`
     * reads these to fix each field's crop ratio and resize target, so what an
     * editor uploads matches the width/height emitted here and no image is
     * stored larger than the design asks for.
     *
     * @var array<string, array{int, int}>
     */
    public const DIMENSIONS = [
EDIT_EOT
],
        [<<<'EDIT_EOT'
        'section' => [1248, 624],            // generic section image
    ];
EDIT_EOT
, <<<'EDIT_EOT'
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
EDIT_EOT
],
        ["        [\$width, \$height] = self::DIMENSIONS[\$context] ?? self::DIMENSIONS['section'];",
         "        [\$width, \$height] = self::dimensions(\$context);"],
    ],
],

'app/Filament/Resources/ClientResource.php' => [
    'sha' => '95b6394b7ba9fe796775e8a6889e57bad7828321c86e5c36f0b0a9fae82969ac',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\Client;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\Client;
use Filament\Forms\Components\Section;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                    FileUpload::make('logo_path')
                        ->label('Logo (SVG preferred)')
                        ->directory('clients')
                        ->disk('public')
                        ->acceptedFileTypes(['image/svg+xml', 'image/png', 'image/webp'])
                        ->required()
EDIT_EOT
, <<<'EDIT_EOT'
                    ImageUpload::logo('logo_path', 'Logo (SVG preferred)', 'clients')
                        ->required()
EDIT_EOT
],
    ],
],

'app/Filament/Resources/TeamMemberResource.php' => [
    'sha' => '2751edbbe9de671891920a80017e2cdbdd2294a9a549d152fc2ab4073d968256',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\TeamMember;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\TeamMember;
use Filament\Forms\Components\Section;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                    FileUpload::make('photo_path')
                        ->label('Portrait')
                        ->image()
                        // Keep team portraits on the regular Livewire upload path.
                        // The client-side editor can remain indefinitely in its
                        // uploading state for this field in local/admin builds.
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->maxSize(20480)
                        ->directory('team')
                        ->disk('public')
                        ->columnSpanFull(),
EDIT_EOT
, <<<'EDIT_EOT'
                    ImageUpload::make('photo_path', 'Portrait', 'team', 'team')
                        ->columnSpanFull(),
EDIT_EOT
],
    ],
],

'app/Filament/Resources/TestimonialResource.php' => [
    'sha' => 'afe196f56c948d8f0cad6846a318c07ff296c0e1b082b4eb3c88e47a8050b2c3',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\Testimonial;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\Testimonial;
use Filament\Forms\Components\Section;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                    FileUpload::make('avatar_path')
                        ->label('Avatar')
                        ->image()
                        ->imageEditor()
                        ->avatar()
                        ->directory('testimonials')
                        ->disk('public')
                        ->columnSpanFull(),
EDIT_EOT
, <<<'EDIT_EOT'
                    ImageUpload::avatar('avatar_path', 'Avatar', 'testimonial', 'testimonials')
                        ->columnSpanFull(),
EDIT_EOT
],
    ],
],

'app/Filament/Resources/ServiceResource.php' => [
    'sha' => 'f22434eed72e0d6a1daecbb8f2971ea449b56143087de2be71c6935381e2bac8',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\PublicationFields;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\PublicationFields;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\Service;
use Filament\Forms\Components\Grid;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                        FileUpload::make('image_path')
                            ->label('Service image')
                            ->image()
                            ->imageEditor()
                            ->directory('services')
                            ->disk('public'),
EDIT_EOT
, <<<'EDIT_EOT'
                        ImageUpload::make('image_path', 'Service image', 'service', 'services'),
EDIT_EOT
],
    ],
],

'app/Filament/Resources/ProjectResource.php' => [
    'sha' => '099cef3bc6e65d88a352c0cad737cb054024ae92a7a5db7f2aa019f77f897720',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Support\PublicationFields;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\PublicationFields;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\Service;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\Service;
use Filament\Forms\Components\Grid;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                            FileUpload::make('cover_path')
                                ->label('Cover (square)')
                                ->image()
                                ->imageEditor()
                                ->directory('projects')
                                ->disk('public')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),

                            FileUpload::make('banner_path')
                                ->label('Case-study banner')
                                ->image()
                                ->imageEditor()
                                ->directory('projects')
                                ->disk('public'),

                            FileUpload::make('before_image_path')
                                ->label('Before')
                                ->image()
                                ->directory('projects')
                                ->disk('public'),

                            FileUpload::make('after_image_path')
                                ->label('After')
                                ->image()
                                ->directory('projects')
                                ->disk('public'),
EDIT_EOT
, <<<'EDIT_EOT'
                            ImageUpload::make('cover_path', 'Cover (square)', 'project.cover', 'projects'),

                            ImageUpload::make('banner_path', 'Case-study banner', 'project.banner', 'projects'),

                            ImageUpload::make('before_image_path', 'Before', 'project.beforeafter', 'projects'),

                            ImageUpload::make('after_image_path', 'After', 'project.beforeafter', 'projects'),
EDIT_EOT
],
    ],
],

'app/Filament/Resources/PostResource.php' => [
    'sha' => '6dcd41cb27ff421476a2bf7181672ec5b656c62108e1aa8aa4c54f93cb03c062',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Filament\Resources\PostResource\RelationManagers\LeadMagnetDeliveriesRelationManager;
use App\Filament\Support\PublicationFields;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Filament\Resources\PostResource\RelationManagers\LeadMagnetDeliveriesRelationManager;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\PublicationFields;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                        FileUpload::make('cover_path')
                            ->label('Cover image')
                            ->image()
                            ->imageEditor()
                            ->directory('posts')
                            ->disk('public'),
EDIT_EOT
, <<<'EDIT_EOT'
                        ImageUpload::make('cover_path', 'Cover image', 'post.cover', 'posts'),
EDIT_EOT
],
        [<<<'EDIT_EOT'
                            FileUpload::make('lead_magnet_image_path')
                                ->label('Banner background')
                                ->image()
                                ->imageEditor()
                                ->directory('posts/lead-magnets')
                                ->disk('public'),
EDIT_EOT
, <<<'EDIT_EOT'
                            ImageUpload::make(
                                'lead_magnet_image_path',
                                'Banner background',
                                'post.hero',
                                'posts/lead-magnets',
                            ),
EDIT_EOT
],
    ],
],

'app/Filament/Pages/ManageSettings.php' => [
    'sha' => '044f72ba5a2cdac1175535bab023fb2c4b78ffd707b72860c765a8f4db555e84',
    'edits' => [
        [<<<'EDIT_EOT'
namespace App\Filament\Pages;

use App\Models\Setting;
EDIT_EOT
, <<<'EDIT_EOT'
namespace App\Filament\Pages;

use App\Filament\Support\ImageUpload;
use App\Models\Setting;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
EDIT_EOT
, <<<'EDIT_EOT'
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
EDIT_EOT
],
        [<<<'EDIT_EOT'
                        FileUpload::make('seo_default_image')
                            ->label('Default share image')
                            ->image()
                            ->directory('seo')
                            ->disk('public')
                            ->helperText('Shown when a page has no image. 1200×630 recommended.'),
EDIT_EOT
, <<<'EDIT_EOT'
                        ImageUpload::make('seo_default_image', 'Default share image', 'seo.share', 'seo')
                            ->helperText('Shown when a page has no image. Cropped to the 1200×630 Open Graph card.'),
EDIT_EOT
],
    ],
],

'app/Filament/Resources/ProjectResource/RelationManagers/ImagesRelationManager.php' => [
    'sha' => '9730fa26bdfa59ec215dda9521808f7baecbfc93830ccf5c58258229a9570e35',
    'edits' => [
        [<<<'EDIT_EOT'
namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Support\TranslatableForm;
EDIT_EOT
, <<<'EDIT_EOT'
namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Support\ImageUpload;
use App\Filament\Support\TranslatableForm;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use App\Models\ProjectImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Models\ProjectImage;
use Filament\Forms\Components\TextInput;
EDIT_EOT
],
        [<<<'EDIT_EOT'
            FileUpload::make('path')
                ->label('Image')
                ->image()
                ->imageEditor()
                ->directory('projects/showcase')
                ->disk('public')
                ->required()
EDIT_EOT
, <<<'EDIT_EOT'
            ImageUpload::make('path', 'Image', 'project.showcase', 'projects/showcase')
                ->required()
EDIT_EOT
],
    ],
],

'app/Filament/Resources/ProjectResource/RelationManagers/SectionsRelationManager.php' => [
    'sha' => 'b370537b4b5c74fb6f81d81a475ced43bea205ca7ef1759a3348c2a9e2de7ce5',
    'edits' => [
        [<<<'EDIT_EOT'
use App\Enums\SectionType;
use App\Filament\Support\SvgIconUpload;
EDIT_EOT
, <<<'EDIT_EOT'
use App\Enums\SectionType;
use App\Filament\Support\ImageUpload;
use App\Filament\Support\SvgIconUpload;
EDIT_EOT
],
        [<<<'EDIT_EOT'
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
EDIT_EOT
, <<<'EDIT_EOT'
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
EDIT_EOT
],
        [<<<'EDIT_EOT'
            FileUpload::make('image_path')
                ->label('Section image')
                ->image()
                ->imageEditor()
                ->directory('sections')
                ->disk('public')
                ->columnSpanFull(),
EDIT_EOT
, <<<'EDIT_EOT'
            ImageUpload::make('image_path', 'Section image', 'section', 'sections')
                ->columnSpanFull(),
EDIT_EOT
],
    ],
],

'tests/Feature/Admin/ImageUploadTest.php' => [
    'sha' => '82520bf9105cbb52f1cd9b601aada8ce4c87583401cc538ec0683330c3a6fae2',
    'prior' => ['029b2eb84dc53b7953fc0d786c4bab7691b3af41ade5ad97220dc27a1248211f'],
    'create' => <<<'EDIT_EOT'
<?php

declare(strict_types=1);

use App\Filament\Support\ImageUpload;
use App\Services\MediaTransformer;
use Filament\Forms\Components\FileUpload;

it('crops to the ratio the frontend renders the image at', function (string $context): void {
    [$width, $height] = MediaTransformer::dimensions($context);

    $field = ImageUpload::make('path', 'Image', $context);

    expect($field->getImageCropAspectRatio())->toBe("{$width}:{$height}");

    // Same ratio at the stored size, so the automatic transform and a manual
    // crop in the editor cannot disagree about the shape of the result.
    $stored = (int) $field->getImageResizeTargetWidth() / (int) $field->getImageResizeTargetHeight();

    expect($stored)->toBeGreaterThan($width / $height - 0.01)
        ->and($stored)->toBeLessThan($width / $height + 0.01);
})->with(array_keys(MediaTransformer::DIMENSIONS));

it('keeps every stored image inside the retina bounds', function (string $context): void {
    $field = ImageUpload::make('path', 'Image', $context);

    $longest = max(
        (int) $field->getImageResizeTargetWidth(),
        (int) $field->getImageResizeTargetHeight(),
    );

    expect($longest)->toBeGreaterThanOrEqual(640)
        ->and($longest)->toBeLessThanOrEqual(2400);
})->with(array_keys(MediaTransformer::DIMENSIONS));

it('scales a small design size up to a usable one', function (): void {
    // The testimonial avatar renders at 48×48; storing it at 96 would make it
    // useless anywhere else.
    $field = ImageUpload::avatar('avatar_path', 'Avatar', 'testimonial');

    expect($field->getImageResizeTargetWidth())->toBe('640')
        ->and($field->getImageResizeTargetHeight())->toBe('640');
});

it('caps a large design size rather than storing it at 2x', function (): void {
    // page.hero is 1440×904; doubled it would be 2880 wide.
    $field = ImageUpload::make('hero', 'Hero', 'page.hero');

    expect($field->getImageResizeTargetWidth())->toBe('2400')
        ->and($field->getImageResizeTargetHeight())->toBe('1507');
});

it('shapes the editor crop box like the target, so both routes agree', function (string $context): void {
    // Filament derives the viewport from the resize target (360 px wide,
    // height to match), so setting it by hand would be ignored. Assert the
    // shape it lands on rather than the numbers.
    $field = ImageUpload::make('path', 'Image', $context);

    $viewport = $field->getImageEditorViewportWidth() / $field->getImageEditorViewportHeight();
    $target = (int) $field->getImageResizeTargetWidth() / (int) $field->getImageResizeTargetHeight();

    expect($field->hasImageEditor())->toBeTrue()
        ->and($viewport)->toEqualWithDelta($target, 0.02);
})->with(array_keys(MediaTransformer::DIMENSIONS));

it('never upscales a source smaller than the target', function (): void {
    expect(ImageUpload::make('path', 'Image', 'section')->getImageResizeUpscale())->toBeFalse()
        ->and(ImageUpload::avatar('path', 'Avatar', 'testimonial')->getImageResizeUpscale())->toBeFalse();
});

it('accepts only raster formats the browser can transform', function (): void {
    expect(ImageUpload::make('path', 'Image', 'section')->getAcceptedFileTypes())
        ->toBe(['image/jpeg', 'image/png', 'image/webp']);
});

it('leaves logos untransformed so an SVG is not rasterised', function (): void {
    $field = ImageUpload::logo('logo_path', 'Logo');

    expect($field->getImageResizeTargetWidth())->toBeNull()
        ->and($field->getImageResizeTargetHeight())->toBeNull()
        ->and($field->getImageCropAspectRatio())->toBeNull()
        ->and($field->hasImageEditor())->toBeFalse()
        ->and($field->getAcceptedFileTypes())->toContain('image/svg+xml');
});

it('stores uploads on the public disk', function (): void {
    $field = ImageUpload::make('cover_path', 'Cover', 'project.cover', 'projects');

    expect($field->getDiskName())->toBe('public')
        ->and($field->getDirectory())->toBe('projects');
});

/*
 * Regression guard: image fields must go through ImageUpload, or they upload at
 * full camera resolution, with no crop ratio and no resize target — storing an
 * image that does not match the width and height the frontend claims for it.
 */
it('routes every admin image field through the shared uploader', function (): void {
    $offenders = [];

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(app_path('Filament')),
    );

    foreach ($files as $file) {
        // Support/ is where the sanctioned builders live — ImageUpload itself
        // is the one place a raw image FileUpload is meant to be configured.
        if ($file->getExtension() !== 'php' || str_contains($file->getPath(), 'Support')) {
            continue;
        }

        $source = file_get_contents($file->getPathname());

        if (preg_match('/FileUpload::make\([^)]*\)\s*(->[^;]*?)?->image\(\)/s', $source)) {
            $offenders[] = $file->getFilename();
        }
    }

    expect($offenders)->toBe([]);
});

it('exposes the same dimensions the uploader and the frontend both read', function (): void {
    expect(MediaTransformer::dimensions('project.cover'))->toBe([448, 448])
        ->and(MediaTransformer::dimensions('does-not-exist'))->toBe(MediaTransformer::DIMENSIONS['section']);
});

it('is the type Filament expects', function (): void {
    expect(ImageUpload::make('path', 'Image', 'section'))->toBeInstanceOf(FileUpload::class);
});
EDIT_EOT
],

];

// ------------------------------------------------------------------ gate ---

$isCli = PHP_SAPI === 'cli';

if (! $isCli) {
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex, nofollow');

    $given = (string) ($_GET['token'] ?? '');

    if (! hash_equals(TOKEN, $given)) {
        http_response_code(404);
        exit("Not found.\n");
    }
}

$apply = $isCli
    ? in_array('--run', $argv ?? [], true)
    : ($_GET['run'] ?? '') === '1';

$keep = $isCli
    ? in_array('--keep', $argv ?? [], true)
    : ($_GET['keep'] ?? '') === '1';

// -------------------------------------------------------- locate the app ---

/**
 * Directories worth checking.
 *
 * Walking up stops at the account home: on cPanel, open_basedir makes anything
 * above it throw rather than return false. Guessing names above public_html is
 * no good either — the app directory is named whatever the person who set the
 * account up chose — so the home directory is searched two levels deep instead.
 *
 * @return list<string>
 */
function candidateRoots(): array
{
    $found = [];
    $dir = __DIR__;

    for ($i = 0; $i < 6; $i++) {
        $found[] = $dir;
        $parent = dirname($dir);

        // '/home/user' has two slashes; one fewer means the next step up leaves
        // the account, which is where open_basedir starts complaining.
        if ($parent === $dir || substr_count($parent, '/') < 2) {
            break;
        }

        $dir = $parent;
    }

    // Glob from every level walked, not just the top one: the app directory is
    // most often a sibling of public_html, which is one level up from here.
    foreach ($found as $level) {
        foreach ((array) @glob($level.'/*/artisan') as $hit) {
            $found[] = dirname((string) $hit);
        }
    }

    return array_values(array_unique($found));
}

/**
 * A Laravel root, and what composer.json calls it — or null.
 *
 * @return array{root: string, name: string}|null
 */
function inspectRoot(string $dir): ?array
{
    if (! @is_file($dir.'/artisan') || ! @is_file($dir.'/composer.json')) {
        return null;
    }

    $composer = json_decode((string) @file_get_contents($dir.'/composer.json'), true);

    return [
        'root' => realpath($dir) ?: $dir,
        'name' => is_array($composer) ? (string) ($composer['name'] ?? '(no name)') : '(unreadable)',
    ];
}

$override = $isCli
    ? null
    : (isset($_GET['root']) ? rtrim((string) $_GET['root'], '/') : null);

$laravelRoots = [];

foreach ($override !== null ? [$override] : candidateRoots() as $candidate) {
    $found = inspectRoot($candidate);

    if ($found !== null) {
        $laravelRoots[] = $found;
    }
}

/*
 * Only the NEAREST install counts. An account can host several sites, and a
 * staging copy or an unrelated app further up the tree must never be written
 * to just because its composer.json happens to carry the right name — so if
 * the closest Laravel root is not this project, stop and say so rather than
 * reaching past it.
 */
$nearest = $laravelRoots[0] ?? null;

// An explicit &root= is the operator saying "I have checked, it is this one",
// which is the whole point of the flag — so it skips the name check. It still
// has to be a Laravel root, and the checksum gate still guards every write.
$root = match (true) {
    $nearest === null => null,
    $override !== null => $nearest['root'],
    $nearest['name'] === PROJECT => $nearest['root'],
    default => null,
};

echo "Sahra — admin image upload + resize\n";
echo str_repeat('=', 62), "\n\n";

if ($root === null) {
    echo "FAILED: no '".PROJECT."' project found from ".__DIR__."\n\n";

    if ($laravelRoots !== []) {
        echo "The nearest Laravel install is not this project:\n\n";

        foreach ($laravelRoots as $i => $found) {
            printf("  %s %-46s composer name: %s\n",
                $i === 0 ? '→' : ' ', $found['root'], $found['name']);
        }

        echo "\nNothing further up was considered — writing to the wrong site is\n";
        echo "worse than not deploying. If the arrowed path IS the site and its\n";
        echo "composer.json simply says something else, re-run with:\n\n";
        echo '  ?token=', TOKEN, '&root=', $laravelRoots[0]['root'], "\n";
        exit(1);
    }

    echo "Searched:\n";

    foreach (candidateRoots() as $candidate) {
        printf("  %s\n", $candidate);
    }

    // The directory holding public_html is where the app almost always lives,
    // so list that rather than wherever the upward walk happened to stop.
    $home = dirname(__DIR__);

    echo "\nWhat is in ", $home, ":\n";

    foreach ((array) @scandir($home) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        printf("  %s%s\n", $entry, @is_dir($home.'/'.$entry) ? '/' : '');
    }

    // public/index.php is rewritten to point at the app directory on shared
    // hosting, so whatever it requires is the most reliable hint there is.
    $index = __DIR__.'/index.php';

    if (@is_file($index)) {
        echo "\nWhat ", $index, " points at:\n";

        foreach (explode("\n", (string) @file_get_contents($index)) as $line) {
            if (preg_match('/require|__DIR__|autoload|bootstrap/i', $line)) {
                echo '  ', trim($line), "\n";
            }
        }
    }

    echo "\nRe-run with &root=/home/you/the-app-directory once you can see it above.\n";
    exit(1);
}

echo 'Project root : ', $root, "\n";

if ($override !== null && ($nearest['name'] ?? '') !== PROJECT) {
    echo '               (forced by &root=; composer.json calls it "',
        $nearest['name'] ?? '?', '")', "\n";
}

echo 'Mode         : ', $apply ? 'APPLY' : 'dry run (add &run=1 to write)', "\n\n";

// ---------------------------------------------------------------- report ---

echo "Host\n----\n";
printf("  PHP              %s\n", PHP_VERSION);
printf("  gd / imagick     %s / %s\n",
    extension_loaded('gd') ? 'yes' : 'no',
    extension_loaded('imagick') ? 'yes' : 'no');
printf("  upload_max_size  %s\n", ini_get('upload_max_filesize'));
printf("  post_max_size    %s\n", ini_get('post_max_size'));
printf("  storage symlink  %s\n",
    is_link($root.'/public/storage') || is_dir($root.'/public/storage') ? 'present' : 'MISSING');
echo "\n";

// ----------------------------------------------------------------- work ----

$backupDir = $root.'/storage/app/deploy-backups/'.date('Ymd-His');
$results = [];
$blocked = 0;
$pending = 0;

foreach ($PLAN as $path => $spec) {
    $full = $root.'/'.$path;
    $exists = is_file($full);
    $current = $exists ? (string) file_get_contents($full) : '';
    $currentHash = $exists ? hash('sha256', $current) : null;
    $found = $exists ? ' (found '.substr((string) $currentHash, 0, 8).')' : '';

    // Already at the target? Nothing to do, whichever route got it there.
    if ($currentHash === $spec['sha']) {
        $results[] = ['ok', $path, 'already up to date'];
        continue;
    }

    if (isset($spec['create'])) {
        // A file this deployer wrote on an earlier run is ours to update. Any
        // other content is somebody's work and is left alone.
        $ours = in_array($currentHash, $spec['prior'] ?? [], true);

        if ($exists && ! $ours) {
            $results[] = ['skip', $path, 'exists but is not a version this deployer wrote'.$found];
            $blocked++;
            continue;
        }

        $next = $spec['create']."\n";
    } else {
        if (! $exists) {
            $results[] = ['skip', $path, 'missing from this host'];
            $blocked++;
            continue;
        }

        $next = $current;
        $failed = null;

        foreach ($spec['edits'] as $i => [$search, $replace]) {
            $at = strpos($next, $search);

            if ($at !== false) {
                $next = substr_replace($next, $replace, $at, strlen($search));
                continue;
            }

            if (str_contains($next, $replace)) {
                continue;   // that hunk was already applied
            }

            $failed = $i + 1;
            break;
        }

        if ($failed !== null) {
            $results[] = ['skip', $path, "hunk {$failed} did not match — file has diverged".$found];
            $blocked++;
            continue;
        }
    }

    if (hash('sha256', $next) !== $spec['sha']) {
        $results[] = ['skip', $path, 'result would not match the expected checksum'.$found];
        $blocked++;
        continue;
    }

    if (! $apply) {
        $results[] = ['todo', $path, $exists ? 'would update' : 'would create'];
        $pending++;
        continue;
    }

    if ($exists) {
        $dest = $backupDir.'/'.$path;
        @mkdir(dirname($dest), 0755, true);

        if (! @copy($full, $dest)) {
            $results[] = ['skip', $path, 'could not write a backup — not touched'];
            $blocked++;
            continue;
        }
    }

    @mkdir(dirname($full), 0755, true);

    if (@file_put_contents($full, $next) === false) {
        $results[] = ['fail', $path, 'WRITE FAILED — check permissions'];
        $blocked++;
        continue;
    }

    $results[] = ['done', $path, $exists ? 'updated' : 'created'];
}

echo "Files\n-----\n";

foreach ($results as [$state, $path, $note]) {
    printf("  %-5s %-70s %s\n", strtoupper($state), $path, $note);
}

echo "\n";

// --------------------------------------------------------------- finish ----

if (! $apply) {
    echo $blocked > 0
        ? "{$blocked} file(s) would be skipped — read the notes above before running for real.\n"
        : "All clear. Re-run with &run=1 to apply.\n";
    echo "\nNothing was written.\n";
    exit($blocked > 0 ? 1 : 0);
}

if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset.\n";
}

foreach (['config.php', 'services.php', 'packages.php'] as $cache) {
    $file = $root.'/bootstrap/cache/'.$cache;

    if (is_file($file) && @unlink($file)) {
        echo "Cleared bootstrap/cache/{$cache}\n";
    }
}

echo "\nBackups: ", is_dir($backupDir) ? $backupDir : '(none needed)', "\n";

if ($blocked > 0) {
    echo "\n{$blocked} file(s) were skipped. This deployer has NOT deleted itself —\n";
    echo "fix the notes above, re-run, or DELETE THIS FILE BY HAND now.\n";
    exit(1);
}

echo "\nDone. Open /admin and edit any record with an image field.\n";

if ($keep || $isCli) {
    echo $isCli ? "\n(CLI run: file left in place.)\n" : "\n(keep=1: file left in place — DELETE IT.)\n";
    exit(0);
}

echo @unlink(__FILE__)
    ? "\nThis deployer has deleted itself.\n"
    : "\nCOULD NOT DELETE THIS FILE — remove ".basename(__FILE__)." from public_html now.\n";
