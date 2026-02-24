<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Tour;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PopularToursWidget extends BaseWidget
{
    protected ?string $heading = 'Paket Paling Laris';

    protected function getStats(): array
    {
        $popularTours = Booking::select('tour_id')
            ->selectRaw('COUNT(*) as total_bookings')
            ->where('payment_status', 'paid')
            ->whereNotNull('tour_id')
            ->groupBy('tour_id')
            ->orderByDesc('total_bookings')
            ->limit(3)
            ->with('tour')
            ->get();

        $stats = [];
        foreach ($popularTours as $item) {
            if ($item->tour) {
                $stats[] = Stat::make(
                    $item->tour->title,
                    $item->total_bookings.' pemesanan'
                )
                    ->description('Total: '.$item->total_bookings)
                    ->icon('heroicon-o-map')
                    ->color('success');
            }
        }

        if (empty($stats)) {
            $stats[] = Stat::make('Belum ada data', '0 pemesanan')
                ->icon('heroicon-o-information-circle')
                ->color('gray');
        }

        return $stats;
    }
}
