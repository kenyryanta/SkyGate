<?php

namespace App\Filament\Widgets;

use App\Models\Airline;
use App\Models\Customer;
use App\Models\Flight;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('Total registered customers')
                ->descriptionIcon('heroicon-o-user-group')
                ->chart([90, 90, 90, 90])
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'title' => 'Click to view customer details',
                ]),

            Stat::make('Total Airlines', Airline::count())
                ->description('Number of available airlines')
                ->descriptionIcon('heroicon-o-globe-alt')
                ->chart([90, 90, 90, 90])
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'title' => 'Click to view airline details',
                ]),

            Stat::make('Total Flights', Flight::count())
                ->description('Number of available flights')
                ->descriptionIcon('heroicon-o-paper-airplane')
                ->chart([90, 90, 90, 90])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'title' => 'Click to view flight details',
                ]),

            Stat::make('Today\'s Transactions', Transaction::whereDate('created_at', today())->count())
                ->description('Total transactions processed today')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success')
                ->extraAttributes([
                    'footer' => 'Total Revenue: Rp' . number_format(Transaction::whereDate('created_at', today())->sum('grandtotal'), 2, ',', '.'),
                ]),

            Stat::make('Weekly Transactions', Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->description('Total transactions in the last 7 days')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info')
                ->extraAttributes([
                    'footer' => 'Total Revenue: Rp' . number_format(Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('grandtotal'), 2, ',', '.'),
                ]),

            Stat::make('Monthly Transactions', Transaction::whereMonth('created_at', now()->month)->count())
                ->description('Total transactions this month')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('warning')
                ->extraAttributes([
                    'footer' => 'Total Revenue: Rp' . number_format(Transaction::whereMonth('created_at', now()->month)->sum('grandtotal'), 2, ',', '.'),
                ]),

            Stat::make('Total Revenue Today', 'Rp' . number_format(Transaction::whereDate('created_at', today())->sum('grandtotal'), 2, ',', '.'))
                ->description('Total earnings from today\'s transactions')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->extraAttributes([
                    'class' => 'text-sm', // Menggunakan kelas untuk memperkecil font
                ]),

            Stat::make('Total Revenue This Week', 'Rp' . number_format(Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('grandtotal'), 2, ',', '.'))
                ->description('Total earnings from this week\'s transactions')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('info')
                ->extraAttributes([
                    'class' => 'text-sm', // Menggunakan kelas untuk memperkecil font
                ]),

            Stat::make('Total Revenue This Month', 'Rp' . number_format(Transaction::whereMonth('created_at', now()->month)->sum('grandtotal'), 2, ',', '.'))
                ->description('Total earnings from this month\'s transactions')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'text-sm', // Menggunakan kelas untuk memperkecil font
                ]),

        ];
    }

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ]; // Responsive column span for better layout on different screen sizes
}