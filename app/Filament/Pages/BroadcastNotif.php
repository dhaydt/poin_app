<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class BroadcastNotif extends Page
{
    protected static string $view = 'filament.pages.broadcast-notif';
    protected static ?string $slug = 'broadcast-send';
    protected static ?string $label = 'Broadcast Notification';

    protected static ?string $navigationIcon = 'heroicon-o-volume-up';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 7;
}
