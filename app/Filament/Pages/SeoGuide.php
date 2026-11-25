<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Page;

final class SeoGuide extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'SEO';
    protected static ?int $navigationSort = 6;
    protected static ?string $slug = 'seo-guide';
    protected static string $view = 'filament.pages.seo-guide';

    public static function canAccess(): bool { return auth()->user()?->isAdmin() ?? false; }
    public static function getNavigationGroup(): ?string { return __('admin.navigation.groups.SEO'); }
    public static function getNavigationLabel(): string { return __('admin.seo.guide'); }
    public function getTitle(): string { return __('admin.seo.guide'); }
}
