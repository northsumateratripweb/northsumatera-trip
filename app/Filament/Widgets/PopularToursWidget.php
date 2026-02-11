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
            ->where('payment_status', 'success')
            ->groupBy('tour_id')
            ->orderByDesc('total_bookings')
            ->limit(3)
            ->get();

        $stats = [];
        foreach ($popularTours as $booking) {
            $tour = Tour::find($booking->tour_id);
            if ($tour) {
                $stats[] = Stat::make(
                    $tour->title,
                    $booking->total_bookings . ' pemesanan'
                )
                ->description('Total: ' . $booking->total_bookings)
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
