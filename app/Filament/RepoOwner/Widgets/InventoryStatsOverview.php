<?php

namespace App\Filament\RepoOwner\Widgets;

use App\Models\RepositoryStock;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class InventoryStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // position in dashboard

    protected function getStats(): array
    {
        $today = now()->startOfDay();
        $week = now()->startOfWeek();
        $month = now()->startOfMonth();

        $dailyProfit = Order::whereDate('created_at', $today)->sum(DB::raw('total_price - paid'));
        $weeklyProfit = Order::whereBetween('created_at', [$week, now()])->sum(DB::raw('total_price - paid'));
        $monthlyProfit = Order::whereBetween('created_at', [$month, now()])->sum(DB::raw('total_price - paid'));

        return [
            Stat::make('Today Profit', number_format($dailyProfit, 2))
                ->description('Daily net profit')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('This Week Profit', number_format($weeklyProfit, 2))
                ->description('Weekly net profit')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('info'),

            Stat::make('This Month Profit', number_format($monthlyProfit, 2))
                ->description('Monthly net profit')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),
        ];
    }
}
