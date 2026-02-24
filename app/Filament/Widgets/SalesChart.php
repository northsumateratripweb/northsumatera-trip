<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Penjualan Bulanan';

    protected function getData(): array
    {
        $bookings = Booking::where('payment_status', 'success')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d M');
            $data[] = $bookings->get($date, 0);
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
