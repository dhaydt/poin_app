<?php

namespace App\Filament\Resources\RedeemPoinResource\Pages;

use App\Filament\Resources\RedeemPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedeemPoin extends EditRecord
{
    protected static string $resource = RedeemPoinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
