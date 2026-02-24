<?php

namespace App\Filament\Resources\SocialFeedResource\Pages;

use App\Filament\Resources\SocialFeedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocialFeeds extends ListRecords
{
    protected static string $resource = SocialFeedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
