<?php

namespace App\Filament\Resources\BroadcastNotificationResource\Pages;

use App\Filament\Resources\BroadcastNotificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBroadcastNotification extends EditRecord
{
    protected static string $resource = BroadcastNotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
