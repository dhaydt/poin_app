<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\Reward;
use App\Models\User;
use App\Models\Work;
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
        // $user = User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('adminadmin')
        // ]);

        // User::factory()->create([
        //     'name' => 'manager',
        //     'email' => 'manager@manager.com',
        //     'password' => Hash::make('adminadmin')
        // ]);

        // $role = Role::create(['name' => 'admin']);
        // $user->assignRole($role);

        // $users = [
        //     ['type' => 'about_us', 'value' => ''],
        //     ['type' => 'contact', 'value' => ''],
        //     ['type' => 'term_and_condition', 'value' => ''],
        // ];

        // Config::insert($users);

        // $reward = [
        //     ['poin' => 1, 'reward' => null],
        //     ['poin' => 2, 'reward' => null],
        //     ['poin' => 3, 'reward' => null],
        //     ['poin' => 4, 'reward' => null],
        //     ['poin' => 5, 'reward' => null],
        //     ['poin' => 6, 'reward' => null],
        // ];

        // Reward::insert($reward);
        
        $work = [
            ['name' => 'PNS'],
            ['name' => 'Militer / Polisi'],
            ['name' => 'BUMN'],
            ['name' => 'Karyawan Swasta'],
            ['name' => 'Pengusaha'],
            ['name' => 'Guru'],
            ['name' => 'Profesional'],
            ['name' => 'Konten Kreator/Entertaint'],
            ['name' => 'Atlet'],
            ['name' => 'Ibu Rumah Tangga'],
            ['name' => 'Lainnya'],
        ];

        Work::insert($work);
    }
}
