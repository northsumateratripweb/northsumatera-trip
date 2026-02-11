<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function () {
                    // Ensure only one setting exists
                    Setting::firstOrCreateDefault();
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $setting = Setting::firstOrCreateDefault();
        return SettingResource::getUrl('edit', ['record' => $setting->id]);
    }
}
