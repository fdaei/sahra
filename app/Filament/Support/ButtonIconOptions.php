<?php

declare(strict_types=1);

namespace App\Filament\Support;

final class ButtonIconOptions
{
    /** @return array<string, string> */
    public static function all(): array
    {
        return [
            'arrow-right' => 'Arrow right',
            'arrow-left' => 'Arrow left',
            'arrow-up-right' => 'Arrow up right',
            'chevron-right' => 'Chevron right',
            'check' => 'Check',
            'check-circle' => 'Check circle',
            'circle-plus' => 'Plus',
            'download' => 'Download',
            'external-link' => 'External link',
            'eye' => 'Eye',
            'file-text' => 'File',
            'mail' => 'Mail',
            'message-circle' => 'Message',
            'phone' => 'Phone',
            'play' => 'Play',
            'send' => 'Send',
            'shopping-cart' => 'Shopping cart',
            'sparkles' => 'Sparkles',
            'star' => 'Star',
            'user' => 'User',
        ];
    }
}
