<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Pages\ExportCustomer;
use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Concerns\Translatable;

class ListUsers extends ListRecords
{
    use Translatable;
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // Action::make('Export')
            //     ->url(route('export.customer')),
            // LocaleSwitcher::make()
        ];
    }
}
