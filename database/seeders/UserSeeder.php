<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Kasir Demo',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Pembeli 1',
            'email' => 'pembeli1@example.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        User::create([
            'name' => 'Pembeli 2',
            'email' => 'pembeli2@example.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

        User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
