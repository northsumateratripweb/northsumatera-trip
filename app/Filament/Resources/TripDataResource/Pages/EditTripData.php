<?php

namespace App\Filament\Resources\TripDataResource\Pages;

use App\Filament\Resources\TripDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTripData extends EditRecord
{
    protected static string $resource = TripDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
