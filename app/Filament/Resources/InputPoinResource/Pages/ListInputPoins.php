<?php

namespace App\Filament\Resources\InputPoinResource\Pages;

use App\Filament\Resources\InputPoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInputPoins extends ListRecords
{
    protected static string $resource = InputPoinResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
