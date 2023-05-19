<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoin extends EditRecord
{
    protected static string $resource = PoinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
