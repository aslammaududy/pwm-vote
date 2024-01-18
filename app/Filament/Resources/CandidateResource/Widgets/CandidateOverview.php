<?php

namespace App\Filament\Resources\CandidateResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CandidateOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Yang Telah Memilih', User::where('has_chosen', 1)->whereNotIn('id', [1, 2])->count())
        ];
    }
}
