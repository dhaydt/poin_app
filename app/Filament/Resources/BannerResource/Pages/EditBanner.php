<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\CPU\Helpers;
use App\Filament\Resources\BannerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        $id = $this->record->id;
        $title = $this->record->title_eng;
        $desc = $this->record->description_eng;
        Helpers::saveNotif($title, $desc, $id, 'banner');
        return $this->getResource()::getUrl('index');
    }
}
