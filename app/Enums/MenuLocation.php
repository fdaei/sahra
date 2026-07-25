<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Where a Menu renders.
 *
 * Figma: header 1419:9339, footer 1419:9317.
 */
enum MenuLocation: string implements HasLabel
{
    case Header = 'header';
    case Footer = 'footer';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $case): array => $carry + [$case->value => $case->getLabel()],
            [],
        );
    }
}
