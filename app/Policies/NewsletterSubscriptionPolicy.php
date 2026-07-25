<?php

declare(strict_types=1);

namespace App\Policies;

final class NewsletterSubscriptionPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'newsletter_subscription';
    }
}
