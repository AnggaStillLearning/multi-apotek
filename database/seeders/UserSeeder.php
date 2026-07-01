<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([

            'name' => 'Super Admin',

            'email' => 'admin@gmail.com',

            'password' => Hash::make('12345678'),

            'role' => 'super_admin',

            'apotek_id' => null,

        ]);

        User::create([

            'name' => 'Admin Apotek',

            'email' => 'apotek@gmail.com',

            'password' => Hash::make('12345678'),

            'role' => 'admin_apotek',

            'apotek_id' => 1,

        ]);

        User::create([

            'name' => 'Kasir',

            'email' => 'kasir@gmail.com',

            'password' => Hash::make('12345678'),

            'role' => 'kasir',

            'apotek_id' => 1,

        ]);
    }
}
