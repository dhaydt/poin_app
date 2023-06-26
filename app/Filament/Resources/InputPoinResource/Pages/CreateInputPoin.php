<?php

namespace App\Filament\Resources\InputPoinResource\Pages;

use App\Filament\Resources\InputPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInputPoin extends CreateRecord
{
    protected static string $resource = InputPoinResource::class;
    protected static bool $canCreateAnother = false;
}
