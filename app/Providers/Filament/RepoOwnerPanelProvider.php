<?php

namespace App\Providers\Filament;

use App\Filament\RepoOwner\Pages\CustomRegister\CustomRegister;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

class RepoOwnerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('repoOwner')
            ->path('repo-Owner')
            ->registration(CustomRegister::class)
            ->login()
            ->passwordReset()
            ->profile()
            ->font('cairo')
            ->brandLogo(asset('images/logo.png'))
            ->brandLogoHeight('120px')
        ->colors([
                'primary' => Color::Cyan,
            ])
            ->discoverResources(in: app_path('Filament/RepoOwner/Resources'), for: 'App\\Filament\\RepoOwner\\Resources')
            ->discoverPages(in: app_path('Filament/RepoOwner/Pages'), for: 'App\\Filament\\RepoOwner\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/RepoOwner/Widgets'), for: 'App\\Filament\\RepoOwner\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
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
