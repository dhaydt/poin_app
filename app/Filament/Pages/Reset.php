<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Reset extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-trash';

    protected static string $view = 'filament.pages.reset';
    protected static ?string $slug = 'reset';
    protected static ?string $title = 'Reset Data Belanja';

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 8;
}
