<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::unprepared('SET IDENTITY_INSERT users ON');
        User::truncate();
        User::insert([
          [ 'id' => 1,
            'name' => 'Administrator',
            // 'username' => 'admin',
            'email' => 'admin@localhost.com',
            'password' => bcrypt('admin123'),
            'type' => 'admin',
            // 'picture' => 'user_1.png',
            // 'color' => '#FF5733',
            // 'ttd' => 'signature/default.png',
            ],

          [ 'id' => 2,
            'name' => 'User',
            // 'username' => 'user',
            'email' => 'user@localhost.com',
            'password' => bcrypt('user123'),
            'type' => 'user',
            // 'picture' => '',
            // 'color' => '#333CFF',
            // 'ttd' => 'signature/default.png',
            ],

        ]);
        // DB::unprepared('SET IDENTITY_INSERT users OFF');
    }
}
