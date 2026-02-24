<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Review;
use App\Models\TripData;
use App\Models\Tour;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue   = Booking::where('payment_status', 'success')->sum('total_price');
        $monthRevenue   = Booking::where('payment_status', 'success')
            ->whereMonth('created_at', now()->month)->sum('total_price');
        $newBookings    = Booking::where('payment_status', 'pending')->count();
        $pendingReviews = Review::where('is_published', false)->count();
        $tripsToday     = TripData::whereDate('tanggal', Carbon::today())->count();
        $tripsThisWeek  = TripData::whereBetween('tanggal', [
            Carbon::today(), Carbon::today()->addDays(7)
        ])->count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Bulan ini: Rp ' . number_format($monthRevenue, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Pesanan Pending', $newBookings)
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),
            Stat::make('Trip Hari Ini', $tripsToday)
                ->description($tripsThisWeek . ' trip dalam 7 hari ke depan')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('info'),
            Stat::make('Review Tertunda', $pendingReviews)
                ->description('Perlu moderasi')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('danger'),
        ];
    }
}
