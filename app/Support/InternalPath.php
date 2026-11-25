<?php

declare(strict_types=1);

namespace App\Support;

final class InternalPath
{
    public static function valid(mixed $value): bool
    {
        return is_string($value)
            && str_starts_with($value, '/')
            && ! str_starts_with($value, '//')
            && ! str_contains($value, '\\')
            && preg_match('/[\s\x00-\x1f\x7f]/u', $value) === 0;
    }
}
