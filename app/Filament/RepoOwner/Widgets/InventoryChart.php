<?php

namespace App\Filament\RepoOwner\Widgets;

use App\Models\RepositoryStock;
use Filament\Widgets\ChartWidget;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class InventoryChart extends ChartWidget
{
    protected static ?string $heading = 'Inventory Movement';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
         $start = now()->subDays(6)->startOfDay();
        $end   = now()->endOfDay();

         $daily = RepositoryStock::selectRaw('DATE(created_at) as date, SUM(quantity) as qty')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('qty', 'date');

         $period = CarbonPeriod::create($start, $end);
        $labels = [];
        $values = [];

        foreach ($period as $date) {
            $day = $date->format('Y-m-d');
            $labels[] = $day;
            $values[] = $daily[$day] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Inventory',
                    'data' => $values,
                    'backgroundColor' => '#60A5FA', // blue-400
                    'borderColor' => '#2563EB',     // blue-600
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // bar, line, pie
    }
}
