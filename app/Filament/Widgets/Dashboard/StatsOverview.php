<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\PoinHistory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getCards(): array
    {
        return [
            Card::make('Total Customer', count(User::where('is_admin', 0)->get()))
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Total Stamps', array_sum(PoinHistory::where('type', 'add')->get()->pluck('poin')->toArray()))
                ->description('3% decrease')
                ->descriptionIcon('heroicon-s-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            Card::make('Total Redeem', array_sum(PoinHistory::where('type', 'redeem')->get()->pluck('poin')->toArray()))
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),
        ];
    }
}
