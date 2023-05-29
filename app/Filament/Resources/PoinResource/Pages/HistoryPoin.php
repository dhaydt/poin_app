<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Resources\Pages\Page;

class HistoryPoin extends Page
{
    protected static string $resource = PoinResource::class;

    protected static string $view = 'filament.resources.poin-resource.pages.history-poin';
}
