<?php

namespace App\Filament\Resources\PoinResource\Pages;

use App\Filament\Resources\PoinResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePoin extends CreateRecord
{
    protected static string $resource = PoinResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Admin berhasil ditambahkan';
    }
}
