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
        $img = $this->record->image;
        $title = $this->record->title_eng;
        $desc = $this->record->description_eng;
        Helpers::saveNotif($title, $desc, $img);
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Banner berhasil ditambahkan';
    }
}
