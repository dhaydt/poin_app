<?php

namespace App\Filament\Resources\ConfigResource\Pages;

use App\Filament\Resources\ConfigResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateConfig extends CreateRecord
{
    protected static string $resource = ConfigResource::class;
    protected static bool $canCreateAnother = false;
}
