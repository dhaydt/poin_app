<?php

namespace App\Filament\Resources\BroadcastNotificationResource\Pages;

use App\Filament\Resources\BroadcastNotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBroadcastNotifications extends ListRecords
{
    protected static string $resource = BroadcastNotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
