<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected ?string $heading = 'Sales Overview';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Penjualan', 'Rp '.number_format(Booking::where('payment_status', 'paid')->sum('total_price'), 0, ',', '.')),
            Stat::make('Booking Aktif', Booking::where('payment_status', 'pending')->count()),
        ];
    }
}
