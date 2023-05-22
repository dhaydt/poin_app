<?php

namespace App\Filament\Resources\InputPoinResource\Pages;

use App\Filament\Resources\InputPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInputPoin extends EditRecord
{
    protected static string $resource = InputPoinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
