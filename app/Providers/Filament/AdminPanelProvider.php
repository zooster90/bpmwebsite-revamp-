<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * ============================================================
 *  Builtech Admin Panel — Professional Configuration
 * ============================================================
 *  Designed to be 100% user-friendly for non-technical staff.
 *  Clear navigation groups, Builtech corporate branding.
 * ============================================================
 */
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(false)
            ->databaseNotifications()

            // ── Branding & Access ──────────────────────────────
            ->brandName('Builtech Admin')
            ->brandLogo(asset('img/logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/61da7874-55a9-46d1-b71c-32ddac2a7740.png'))
            ->profile() // Allow administrators to change their own passwords securely

            // ── Corporate Colors: Builtech Gold + Clean Palette ─────────────
            ->colors([
                'primary'   => Color::hex('#c5a059'), // Builtech Gold
                'gray'      => Color::Slate,
                'success'   => Color::Emerald,
                'warning'   => Color::Amber,
                'danger'    => Color::Rose,
                'info'      => Color::Sky,
            ])
            ->font('Plus Jakarta Sans')
            
            // ── Modern SaaS Sidebar ──────────────────────────
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\Filament\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\Filament\Pages'
            )
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\Filament\Widgets'
            )
            ->widgets([
                AccountWidget::class,
            ])

            // ── Navigation Groups (organizes the sidebar clearly) ──
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Our Projects')
                    ->icon('heroicon-o-building-office-2'),

                NavigationGroup::make()
                    ->label('News & Media')
                    ->icon('heroicon-o-document-text'),

                NavigationGroup::make()
                    ->label('HR & Careers')
                    ->icon('heroicon-o-users'),

                NavigationGroup::make()
                    ->label('Enquiries')
                    ->icon('heroicon-o-inbox-arrow-down'),

                NavigationGroup::make()
                    ->label('Awards & Achievements')
                    ->icon('heroicon-o-shield-check'),

                NavigationGroup::make()
                    ->label('Company Culture')
                    ->icon('heroicon-o-camera'),
                    
                NavigationGroup::make()
                    ->label('Analytics & Reports')
                    ->icon('heroicon-o-chart-bar-square'),

                NavigationGroup::make()
                    ->label('Settings & Core')
                    ->icon('heroicon-o-cog-8-tooth'),
            ])

            // ── Middleware ─────────────────────────────────────
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::head.end',
                fn (): string => \Illuminate\Support\Facades\Blade::render('@include("filament.custom-css")')
            );
    }
}
