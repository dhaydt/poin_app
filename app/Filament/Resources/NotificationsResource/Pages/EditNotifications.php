<?php

namespace App\Filament\Resources\NotificationsResource\Pages;

use App\Filament\Resources\NotificationsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotifications extends EditRecord
{
    protected static string $resource = NotificationsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
