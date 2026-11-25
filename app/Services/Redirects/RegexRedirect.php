<?php

declare(strict_types=1);

namespace App\Services\Redirects;

final class RegexRedirect
{
    public static function pattern(string $source): ?string
    {
        $source = trim($source);
        if ($source === '' || strlen($source) > 500 || str_contains($source, "\0")) {
            return null;
        }
        if (preg_match('%^([#~/])(.*)\1([imsxuU]*)$%s', $source, $parts) === 1) {
            $delimiter = $parts[1];
            $pattern = $delimiter.'(*LIMIT_MATCH=100000)(*LIMIT_DEPTH=1000)'.$parts[2].$delimiter.$parts[3];
        } else {
            $source = trim($source, '/');
            $pattern = '~(*LIMIT_MATCH=100000)(*LIMIT_DEPTH=1000)^(?:'.str_replace('~', '\\~', $source).')$~u';
        }

        return @preg_match($pattern, '') === false ? null : $pattern;
    }
}
