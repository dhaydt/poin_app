<?php

namespace App\Filament\Resources\BroadcastNotificationResource\Pages;

use App\Filament\Resources\BroadcastNotificationResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListBroadcastNotifications extends ListRecords
{
    protected static string $resource = BroadcastNotificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // Action::make('broadcast')
            // ->url(fn (Collection $get): string => route('broadcast', [' mdata' => $get]))
            // ->openUrlInNewTab()
        ];
    }
}
