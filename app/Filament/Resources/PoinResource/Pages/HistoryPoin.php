<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class HistoryPoin extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PoinResource::class;

    protected static string $view = 'filament.resources.poin-resource.pages.history-poin';

    public $user_id;

    public function mount($id): void
    {
        $this->user_id = $id;
    }
}
