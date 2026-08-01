<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Http\Middleware\SetAdminLocale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Admin panel at /admin.
 *
 * Deliberately NOT locale-prefixed. The panel language is stored separately
 * in the session, while the content it edits remains trilingual.
 *
 * Access is gated by User::canAccessPanel() (admin | editor) and then
 * per-resource by the policies in app/Policies.
 */
final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset()
            ->profile(isSimple: false)
            ->brandName('Sahra')
            ->favicon(asset('favicon.ico'))
            ->colors([
                // Figma "primary gold" #BD933B
                'primary' => Color::hex('#BD933B'),
                'gray' => Color::Slate,
            ])
            ->font('Inter')
            ->maxContentWidth('full')
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets',
            )
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label(__('admin.language.english'))
                    ->icon('heroicon-o-language')
                    ->url(fn (): string => route('admin.locale', ['locale' => 'en']))
                    ->visible(fn (): bool => app()->getLocale() !== 'en')
                    ->sort(-2),
                MenuItem::make()
                    ->label(__('admin.language.persian'))
                    ->icon('heroicon-o-language')
                    ->url(fn (): string => route('admin.locale', ['locale' => 'fa']))
                    ->visible(fn (): bool => app()->getLocale() !== 'fa')
                    ->sort(-2),
            ])
            ->navigationGroups([
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Website content'))
                    ->icon('heroicon-o-document-text'),
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Projects'))
                    ->icon('heroicon-o-briefcase'),
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Articles'))
                    ->icon('heroicon-o-newspaper'),
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Website setup'))
                    ->icon('heroicon-o-globe-alt'),
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Messages'))
                    ->icon('heroicon-o-inbox'),
                NavigationGroup::make(fn (): string => __('admin.navigation.groups.Advanced'))
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetAdminLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop();
    }
}
