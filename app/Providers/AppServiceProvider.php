<?php

namespace App\Providers;

use App\CPU\Helpers;
use App\Filament\Pages\BroadcastNotif;
use App\Filament\Pages\Reset;
use App\Filament\Resources\AdminResource;
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\BroadcastNotificationResource;
use App\Filament\Resources\CatalogResource;
use App\Filament\Resources\ConfigResource;
use App\Filament\Resources\InputPoinResource;
use App\Filament\Resources\NotificationsResource;
use App\Filament\Resources\OutletResource;
use App\Filament\Resources\PoinResource;
use App\Filament\Resources\PoinRewardResource;
use App\Filament\Resources\RedeemPoinResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Filament\Notifications\BroadcastNotification;
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
        // Helpers::checkExpire();
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

        Filament::serving(function () {
            // Using Laravel Mix
            Filament::registerTheme(
                mix('css/filament.css'),
            );
        });

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Ganti Password')
                    ->url(route('filament.pages.settings'))
                    ->icon('heroicon-s-cog'),
                // ...
            ]);
        });

        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            if (Helpers::getRole()) {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->activeIcon('heroicon-s-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                        ->url(route('filament.pages.dashboard')),
                    ...BannerResource::getNavigationItems(),
                    ...CatalogResource::getNavigationItems(),
                    ...OutletResource::getNavigationItems(),
                ])
                ->groups([
                    NavigationGroup::make('Transaksi')->items([
                        ...InputPoinResource::getNavigationItems(),
                        ...RedeemPoinResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Poin')->items([
                        ...PoinResource::getNavigationItems(),
                        ...PoinRewardResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Pengguna')->items([
                        ...UserResource::getNavigationItems(),
                        ...AdminResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Pengaturan')->items([
                        ...BroadcastNotif::getNavigationItems(),
                        ...BroadcastNotificationResource::getNavigationItems(),
                        ...NotificationsResource::getNavigationItems(),
                        ...Reset::getNavigationItems(),
                        ...ConfigResource::getNavigationItems(),
                    ])
                ]);
            } else {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->activeIcon('heroicon-s-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                        ->url(route('filament.pages.dashboard')),
                    ...BannerResource::getNavigationItems(),
                    ...CatalogResource::getNavigationItems(),
                    ...OutletResource::getNavigationItems(),
                ])
                ->groups([
                    NavigationGroup::make('Transaksi')->items([
                        ...InputPoinResource::getNavigationItems(),
                        ...RedeemPoinResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Poin')->items([
                        ...PoinResource::getNavigationItems(),
                        ...PoinRewardResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Pengguna')->items([
                        ...UserResource::getNavigationItems(),
                    ])
                ])
                ->groups([
                    NavigationGroup::make('Pengaturan')->items([
                        ...BroadcastNotif::getNavigationItems(),
                        ...BroadcastNotificationResource::getNavigationItems(),
                        ...NotificationsResource::getNavigationItems(),
                        ...Reset::getNavigationItems(),
                        ...ConfigResource::getNavigationItems(),
                    ])
                ]);
            }
        });
    }
}
