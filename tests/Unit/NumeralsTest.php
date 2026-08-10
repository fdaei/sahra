<?php

declare(strict_types=1);

use App\Support\Numerals;
use Tests\TestCase;

uses(TestCase::class);

it('uses Latin digits for Arabic display dates', function (): void {
    expect(Numerals::localiseDate('09 مايو 2024', 'ar'))->toBe('09 مايو 2024');
});

it('continues to use Arabic digits for non-date numbers', function (): void {
    expect(Numerals::localiseNumber(2024, 'ar'))->toBe('٢٠٢٤');
});

it('keeps the configured Persian digit style for dates', function (): void {
    expect(Numerals::localiseDate('2024/05/09', 'fa'))->toBe('۲۰۲۴/۰۵/۰۹');
});
