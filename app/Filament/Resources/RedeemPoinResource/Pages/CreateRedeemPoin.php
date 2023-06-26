<?php

namespace App\Filament\Resources\RedeemPoinResource\Pages;

use App\Filament\Resources\RedeemPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRedeemPoin extends CreateRecord
{
    protected static string $resource = RedeemPoinResource::class;
    protected static bool $canCreateAnother = false;
}
