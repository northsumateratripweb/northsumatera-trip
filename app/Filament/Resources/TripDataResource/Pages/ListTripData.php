<?php

namespace App\Filament\Resources\TripDataResource\Pages;

use App\Filament\Resources\TripDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTripData extends ListRecords
{
    protected static string $resource = TripDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->label('Export Excel/CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $records = \App\Models\TripData::all();
                    $csvFileName = 'trip-data-'.now()->format('Y-m-d-H-i-s').'.csv';
                    $headers = [
                        'Content-type' => 'text/csv',
                        'Content-Disposition' => "attachment; filename=$csvFileName",
                        'Pragma' => 'no-cache',
                        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                        'Expires' => '0',
                    ];

                    $columns = ['Tanggal', 'Pelanggan', 'Status', 'Layanan', 'Harga', 'Nomor HP'];

                    $callback = function () use ($records, $columns) {
                        $file = fopen('php://output', 'w');
                        fputcsv($file, $columns);

                        foreach ($records as $record) {
                            fputcsv($file, [
                                $record->tanggal->format('Y-m-d'),
                                $record->nama_pelanggan,
                                $record->status,
                                $record->layanan,
                                $record->harga,
                                $record->nomor_hp,
                            ]);
                        }
                        fclose($file);
                    };

                    return response()->stream($callback, 200, $headers);
                }),
        ];
    }
}
