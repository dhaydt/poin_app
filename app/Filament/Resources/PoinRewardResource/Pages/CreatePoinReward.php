<?php

namespace App\Filament\Resources\PoinRewardResource\Pages;

use App\Filament\Resources\PoinRewardResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePoinReward extends CreateRecord
{
    protected static string $resource = PoinRewardResource::class;
    protected static bool $canCreateAnother = false;
}
