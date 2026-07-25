<?php

declare(strict_types=1);

namespace App\Policies;

final class FaqPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'faq';
    }
}
