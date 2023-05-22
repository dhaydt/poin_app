<?php

namespace App\Providers;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\CatalogResource;
use App\Filament\Resources\ConfigResource;
use App\Filament\Resources\InputPoinResource;
use App\Filament\Resources\OutletResource;
use App\Filament\Resources\PoinResource;
use App\Filament\Resources\PoinRewardResource;
use App\Filament\Resources\RedeemPoinResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Passport::routes();
        // $users = User::get();
        // $role = Role::pluck('name');
        // foreach($users as $u){
        //     if($u['is_admin'] == 0 && !$u->hasRole($role)){
        //         $u->assignRole('customer');
        //     };
        // }
        // dd(auth()->user());
        // if(){}
        // Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
        //     return $builder->items([
        //         NavigationItem::make('Dashboard')
        //             ->icon('heroicon-o-home')
        //             ->activeIcon('heroicon-s-home')
        //             ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
        //             ->url(route('filament.pages.dashboard')),
        //         ...BannerResource::getNavigationItems(),
        //         ...OutletResource::getNavigationItems(),
        //         ...CatalogResource::getNavigationItems(),
        //         ...InputPoinResource::getNavigationItems(),
        //         ...PoinResource::getNavigationItems(),
        //         ...PoinRewardResource::getNavigationItems(),
        //         ...RedeemPoinResource::getNavigationItems(),
        //         ...UserResource::getNavigationItems(),
        //         ...AdminResource::getNavigationItems(),
        //         ...RoleResource::getNavigationItems(),
        //         ...ConfigResource::getNavigationItems(),
        //         NavigationItem::make('Reset data belanja')
        //             ->icon('heroicon-o-trash')
        //             ->activeIcon('heroicon-s-trash')
        //             ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.reset'))
        //             ->url(route('filament.pages.reset')),
        //     ]);
        // });
    }
}
