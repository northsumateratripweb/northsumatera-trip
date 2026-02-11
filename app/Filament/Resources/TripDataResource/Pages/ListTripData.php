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
        ];
    }
}
