<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class IconUrl
{
    public static function resolve(?string $icon): ?string
    {
        if (blank($icon)) {
            return null;
        }

        if (str_starts_with($icon, '/') || str_starts_with($icon, 'http://') || str_starts_with($icon, 'https://')) {
            return $icon;
        }

        return str_ends_with(strtolower($icon), '.svg') || str_contains($icon, '/')
            ? Storage::disk('public')->url($icon)
            : $icon;
    }
}
