<?php

declare(strict_types=1);

namespace App\Policies;

final class ClientPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'client';
    }
}
