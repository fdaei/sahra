<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class SsrUnavailable extends RuntimeException
{
    public static function causedBy(\Throwable $e): bool
    {
        do {
            if ($e instanceof self) {
                return true;
            }
        } while ($e = $e->getPrevious());

        return false;
    }
}
