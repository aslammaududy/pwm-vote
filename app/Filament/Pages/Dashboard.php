<?php

namespace App\Filament\Pages;


use App\Filament\Resources\CandidateResource;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function mount(): void
    {
        if (!auth()->user()->is_admin) {
            redirect()->intended(CandidateResource::getUrl('vote'));
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->is_admin;
    }
}
