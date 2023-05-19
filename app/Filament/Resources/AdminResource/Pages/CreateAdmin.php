<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Admin berhasil ditambahkan';
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make(12345678);
        $data['is_admin'] = 1;

        return $data;
    }
}
