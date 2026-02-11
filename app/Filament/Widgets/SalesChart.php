<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan Mingguan';

    protected function getData(): array
    {
        $bookings = Booking::where('payment_status', 'success')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D, d M');
            
            $amount = $bookings
                ->where('created_at', '>=', $date->startOfDay())
                ->where('created_at', '<=', $date->endOfDay())
                ->sum('total_price');
            
            $data[] = $amount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan (Rp)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(255, 68, 51, 0.8)',
                    'borderColor' => 'rgba(255, 68, 51, 1)',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
