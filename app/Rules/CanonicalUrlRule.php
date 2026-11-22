<?php

declare(strict_types=1);

namespace App\Rules;

use App\Support\SeoCanonical;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class CanonicalUrlRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (filled($value) && (! is_string($value) || ! SeoCanonical::valid($value))) {
            $fail(__('Enter a valid HTTP or HTTPS URL without credentials or a fragment.'));
        }
    }
}
