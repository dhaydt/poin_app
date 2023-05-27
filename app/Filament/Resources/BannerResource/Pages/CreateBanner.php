<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\CPU\Helpers;
use App\Filament\Resources\BannerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;
    protected function getRedirectUrl(): string
    {
        $id = $this->record->id;
        $title = $this->record->title_eng;
        $desc = $this->record->description_eng;
        Helpers::saveNotif($title, $desc, $id, 'banner');
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Banner berhasil ditambahkan';
    }
}
