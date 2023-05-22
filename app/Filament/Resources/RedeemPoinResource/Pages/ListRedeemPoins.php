<?php

namespace App\Filament\Resources\RedeemPoinResource\Pages;

use App\Filament\Resources\RedeemPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRedeemPoins extends ListRecords
{
    protected static string $resource = RedeemPoinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
