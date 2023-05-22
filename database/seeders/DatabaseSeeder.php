<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin')
        ]);

        User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('adminadmin')
        ]);

        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);

        $users = [
            ['type' => 'about_us', 'value' => ''],
            ['type' => 'contact', 'value' => ''],
            ['type' => 'term_and_condition', 'value' => ''],
        ];

        Config::insert($users);
    }
}
