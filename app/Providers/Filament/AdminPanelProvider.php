<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Stone,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])->renderHook(
                'panels::topbar.start',
                fn(): string => new HtmlString(
                    '<h3>
                              MUSYAWARAH WILAYAH XXI IKATAN PELAJAR MUHAMMADIYAH ACEH Banda Aceh, 19-21 Januari 2024
                          </h3>',
                )
            )
            ->renderHook(
                'panels::head.start',
                fn(): string => new HtmlString(
                    '<title>
                             Muswil XXI
                          </title>',
                )
            )
//            ->brandName(new HtmlString(
//                    '<div class="grid grid-flow-col auto-cols-max">
//                        <div>
//                            <img width="60" src=' . asset("images/musywil-pelajar.png") . '>
//                        </div>
//                        <div>
//                            <img width="20" src=' . asset("images/Logo-Ikatan-Pelajar-Muhammadiyah-Resmi-10-x-10.png") . '>
//                        </div>
//                    </div>'
//                )
//            )
            ->brandName(new HtmlString(
                    '<img width=150 src=' . asset("images/musywilipm-removebg.png") . '>'
                )
            )
            ->favicon(asset("images/Logo-Ikatan-Pelajar-Muhammadiyah-Resmi-10-x-10.png"))
            ->darkMode(false);
    }
}
