<?php

namespace App\Filament\Pages;


class Dashboard extends \Filament\Pages\Dashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->is_admin;
    }
}
