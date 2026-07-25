<?php

declare(strict_types=1);

namespace App\Policies;

final class ContactSubmissionPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'contact_submission';
    }
}
