<?php

declare(strict_types=1);

namespace App\Policies;

final class SocialLinkPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'social_link';
    }
}
