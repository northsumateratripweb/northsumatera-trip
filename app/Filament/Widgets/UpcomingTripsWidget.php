<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\TripData;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;

class UpcomingTripsWidget extends Widget
{
    protected static string $view = 'filament.widgets.upcoming-trips';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Trip Mendatang';

    public function getViewData(): array
    {
        // Get upcoming trips from TripData (within next 30 days)
        $upcoming = TripData::with('booking')
            ->where('tanggal', '>=', Carbon::today())
            ->where('tanggal', '<=', Carbon::today()->addDays(30))
            ->orderBy('tanggal')
            ->limit(10)
            ->get();

        // Build a calendar map for the current month
        $today       = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth   = $today->copy()->endOfMonth();

        $tripsByDate = TripData::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(fn ($t) => $t->tanggal->format('Y-m-d'));

        $calendar = [];
        // Pad start of month
        $startPadding = $startOfMonth->dayOfWeek; // 0=Sun
        for ($i = 0; $i < $startPadding; $i++) {
            $calendar[] = null;
        }
        // Fill days
        for ($d = 1; $d <= $endOfMonth->day; $d++) {
            $date = $startOfMonth->copy()->day($d);
            $key  = $date->format('Y-m-d');
            $calendar[] = [
                'day'   => $d,
                'date'  => $key,
                'today' => $date->isToday(),
                'trips' => $tripsByDate[$key] ?? collect(),
            ];
        }

        return [
            'upcoming'    => $upcoming,
            'calendar'    => $calendar,
            'monthLabel'  => $today->translatedFormat('F Y'),
        ];
    }
}
