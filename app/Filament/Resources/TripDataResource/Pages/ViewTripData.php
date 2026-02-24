<?php

namespace App\Filament\Resources\TripDataResource\Pages;

use App\Filament\Resources\TripDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTripData extends ViewRecord
{
    protected static string $resource = TripDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_pdf')
                ->label('Cetak Laporan')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('trip-data.pdf', $this->record))
                ->openUrlInNewTab(),
            Actions\EditAction::make(),
        ];
    }
}
