<?php

declare(strict_types=1);

use App\Support\LocalisedUrl;
use Tests\TestCase;

uses(TestCase::class);

it('uses the active locale for internal editor-managed URLs', function (): void {
    expect(LocalisedUrl::for('/en/contact', 'fa'))->toBe('/fa/contact')
        ->and(LocalisedUrl::for('/contact', 'ar'))->toBe('/ar/contact')
        ->and(LocalisedUrl::for('/en/insights/article?source=home#more', 'fa'))->toBe('/fa/insights/article?source=home#more')
        ->and(LocalisedUrl::for('/', 'ar'))->toBe('/ar');
});

it('does not alter external URLs, anchors, or asset paths', function (): void {
    expect(LocalisedUrl::for('https://example.com/en/contact', 'fa'))->toBe('https://example.com/en/contact')
        ->and(LocalisedUrl::for('#contact', 'fa'))->toBe('#contact')
        ->and(LocalisedUrl::for('/storage/brochure.pdf', 'fa'))->toBe('/storage/brochure.pdf');
});
