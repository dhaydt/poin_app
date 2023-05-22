<?php

namespace App\Filament\Resources\PoinRewardResource\Pages;

use App\Filament\Resources\PoinRewardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoinReward extends EditRecord
{
    protected static string $resource = PoinRewardResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
