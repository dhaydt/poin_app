<?php

namespace App\Providers;

use App\Models\User;
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
        
    }
}
