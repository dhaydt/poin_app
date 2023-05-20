<?php

namespace App\Filament\Resources\CatalogResource\Pages;

use App\Filament\Resources\CatalogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalog extends CreateRecord
{
    protected static string $resource = CatalogResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Katalog berhasil ditambahkan';
    }
}
