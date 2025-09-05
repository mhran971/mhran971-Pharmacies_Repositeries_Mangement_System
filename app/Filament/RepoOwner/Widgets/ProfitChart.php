<?php

namespace App\Filament\RepoOwner\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProfitChart extends ChartWidget
{
    protected static ?string $heading = 'Profits Overview';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $profits = Order::selectRaw('DATE(created_at) as date, SUM(total_price - paid) as profit')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(7)
            ->pluck('profit', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Profit',
                    'data' => array_values($profits->toArray()),
                    'backgroundColor' => '#34D399', // green-400
                    'borderColor' => '#059669',     // green-600
                ],
            ],
            'labels' => array_keys($profits->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
