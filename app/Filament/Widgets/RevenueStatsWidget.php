<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\TripData;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueStatsWidget extends BaseWidget
{
    protected ?string $heading = 'Statistik Pendapatan';

    protected function getStats(): array
    {
        $todayRevenue = Booking::where('payment_status', 'success')
            ->whereDate('created_at', today())
            ->sum('total_price');

        $monthRevenue = Booking::where('payment_status', 'success')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $yearRevenue = Booking::where('payment_status', 'success')
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $tripDataRevenue = TripData::where('status', 'completed')
            ->sum('harga');

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp '.number_format($todayRevenue, 0, ',', '.'))
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Pendapatan Bulan Ini', 'Rp '.number_format($monthRevenue, 0, ',', '.'))
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
            Stat::make('Pendapatan Tahun Ini', 'Rp '.number_format($yearRevenue, 0, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->color('warning'),
            Stat::make('Total dari Data Trip', 'Rp '.number_format($tripDataRevenue, 0, ',', '.'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),
        ];
    }
}
