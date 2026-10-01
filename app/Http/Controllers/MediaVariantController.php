<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

final class MediaVariantController extends Controller
{
    public function __invoke(string $format, int $width, string $path): Response
    {
        abort_unless(in_array($width, [400, 736, 1200], true), 404);
        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404);
        $source = $disk->path($path);
        $extension = $format === 'jpeg' ? 'jpg' : $format;
        $target = preg_replace('/\.[^.]+$/', "-{$width}w.{$extension}", $source);

        if (! is_string($target)) abort(404);
        if (! is_file($target)) $this->create($source, $target, $width, $format);
        if (! is_file($target)) return response()->file($source);

        return response()->file($target, ['Cache-Control' => 'public, max-age=31536000, immutable']);
    }

    private function create(string $source, string $target, int $width, string $format): void
    {
        if (! extension_loaded('gd')) return;
        $info = @getimagesize($source);
        if (! $info || $info[0] <= 0) return;
        $input = @imagecreatefromstring((string) file_get_contents($source));
        if (! $input) return;
        $height = (int) round($info[1] * $width / $info[0]);
        $output = imagecreatetruecolor($width, $height);
        imagecopyresampled($output, $input, 0, 0, 0, 0, $width, $height, $info[0], $info[1]);
        if ($format === 'avif' && function_exists('imageavif')) imageavif($output, $target, 55);
        elseif ($format === 'webp' && function_exists('imagewebp')) imagewebp($output, $target, 82);
        else imagejpeg($output, $target, 82);
        imagedestroy($input); imagedestroy($output);
    }
}
