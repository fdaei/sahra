<?php

declare(strict_types=1);

namespace App\Rules;

use App\Services\Redirects\RedirectMap;
use App\Services\Redirects\RedirectSafety;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class RedirectDestination implements ValidationRule
{
    public function __construct(private readonly string $source) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! RedirectSafety::validDestination($value)) {
            $fail(__('Enter a valid destination path or HTTP(S) URL. Local paths cannot include a query or fragment.'));
            return;
        }
        if (RedirectSafety::createsLoop($this->source, $value, RedirectMap::all())) {
            $fail(__('This redirect would create or lead to a redirect loop.'));
        }
    }
}
