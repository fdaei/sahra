<?php

declare(strict_types=1);

namespace App\Policies;

final class TestimonialPolicy extends BasePolicy
{
    protected function resource(): string
    {
        return 'testimonial';
    }
}
