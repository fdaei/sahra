<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class IconUrl
{
    public static function isImage(?string $icon): bool
    {
        return str_starts_with($icon ?? '', '/') || preg_match('~^https?://~', $icon ?? '') === 1;
    }

    public static function resolve(?string $icon): ?string
    {
        if (blank($icon)) {
            return null;
        }

        if (self::isImage($icon)) {
            return $icon;
        }

        return str_ends_with(strtolower($icon), '.svg') || str_contains($icon, '/')
            ? Storage::disk('public')->url($icon)
            : $icon;
    }
}
