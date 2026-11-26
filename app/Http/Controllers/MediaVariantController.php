<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\PathTraversalDetected;

final class MediaVariantController extends Controller
{
    public function __invoke(string $format, int $width, string $path): RedirectResponse
    {
        abort_unless(in_array($width, [400, 736, 1200], true), 404);

        try {
            abort_unless(Storage::disk(Media::DISK)->fileExists($path), 404);
        } catch (PathTraversalDetected) {
            abort(404);
        }

        return redirect()->to(Media::publicUrl($path), 301);
    }
}
