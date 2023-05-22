<?php

namespace App\Filament\Resources\PoinRewardResource\Pages;

use App\Filament\Resources\PoinRewardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPoinRewards extends ListRecords
{
    protected static string $resource = PoinRewardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
