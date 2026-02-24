<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class)

            // ── Branding ──────────────────────────────
            ->brandName('NorthSumatera')
            ->favicon(asset('favicon.ico'))

            // ── Colors ────────────────────────────────
            ->colors([
                'primary'  => Color::Blue,
                'gray'     => Color::Slate,
                'info'     => Color::Sky,
                'success'  => Color::Emerald,
                'warning'  => Color::Amber,
                'danger'   => Color::Rose,
            ])

            // ── Dark mode ─────────────────────────────
            ->darkMode(true)

            // ── Sidebar ───────────────────────────────
            ->sidebarCollapsibleOnDesktop()
            ->sidebarFullyCollapsibleOnDesktop()

            // ── Navigation groups (ordered) ───────────
            ->navigationGroups([
                NavigationGroup::make('Operasional')
                    ->icon('heroicon-o-bolt')
                    ->collapsed(false),
                NavigationGroup::make('Katalog')
                    ->icon('heroicon-o-squares-2x2')
                    ->collapsed(false),
                NavigationGroup::make('Konten')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsed(true),
                NavigationGroup::make('Marketing')
                    ->icon('heroicon-o-megaphone')
                    ->collapsed(true),
                NavigationGroup::make('Pengaturan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(true),
            ])

            // ── Resource & Widget discovery ───────────
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
//            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\SalesChart::class,
                \App\Filament\Widgets\UpcomingTripsWidget::class,
                \App\Filament\Widgets\RevenueStatsWidget::class,
                \App\Filament\Widgets\PopularToursWidget::class,
                \App\Filament\Widgets\PopularToursTableWidget::class,
                \App\Filament\Widgets\SalesOverview::class,
            ])

            // ── Middleware ────────────────────────────
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
