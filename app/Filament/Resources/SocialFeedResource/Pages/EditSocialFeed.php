<?php

namespace App\Filament\Resources\SocialFeedResource\Pages;

use App\Filament\Resources\SocialFeedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialFeed extends EditRecord
{
    protected static string $resource = SocialFeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
