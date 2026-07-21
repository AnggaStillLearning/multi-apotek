<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name'       => 'Super Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'super_admin',
            'apotek_id'  => null,
        ]);

        // Admin Apotek 1
        User::create([
            'name'       => 'Admin Apotek 1',
            'email'      => 'apotek1@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'admin_apotek',
            'apotek_id'  => 1,
        ]);

        // Kasir Apotek 1
        User::create([
            'name'       => 'Kasir 1 Apotek 1',
            'email'      => 'kasir1.apotek1@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'kasir',
            'apotek_id'  => 1,
        ]);

        User::create([
            'name'       => 'Kasir 2 Apotek 1',
            'email'      => 'kasir2.apotek1@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'kasir',
            'apotek_id'  => 1,
        ]);

        // Admin Apotek 2
        User::create([
            'name'       => 'Admin Apotek 2',
            'email'      => 'apotek2@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'admin_apotek',
            'apotek_id'  => 2,
        ]);

        // Kasir Apotek 2
        User::create([
            'name'       => 'Kasir 1 Apotek 2',
            'email'      => 'kasir1.apotek2@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'kasir',
            'apotek_id'  => 2,
        ]);

        User::create([
            'name'       => 'Kasir 2 Apotek 2',
            'email'      => 'kasir2.apotek2@gmail.com',
            'password'   => Hash::make('12345678'),
            'role'       => 'kasir',
            'apotek_id'  => 2,
        ]);
    }
}
