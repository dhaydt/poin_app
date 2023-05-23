<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Broadcast extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-volume-up';

    protected static string $view = 'filament.pages.broadcast';

    protected static ?string $title = 'Boradcast Push Notif';

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 8;
}
