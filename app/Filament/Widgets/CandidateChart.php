<?php

namespace App\Filament\Widgets;

use App\Models\Candidate;
use Filament\Widgets\ChartWidget;

class CandidateChart extends ChartWidget
{
    protected static ?string $heading = 'Hasil Pemilihan';

    protected function getData(): array
    {
        $candidates = Candidate::select(['name', 'votes'])
            ->orderBy('votes')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Kandidat',
                    'data' => $candidates->pluck('votes'),
                ],
            ],
            'labels' => $candidates->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
