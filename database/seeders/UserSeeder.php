<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name' => 'Kasir Demo',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pembeli1@example.com'],
            [
                'name' => 'Pembeli 1',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pembeli2@example.com'],
            [
                'name' => 'Pembeli 2',
                'password' => Hash::make('password'),
                'role' => 'pembeli',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'egafiandra@gmail.com'],
            [
                'name' => 'Kasir Ega',
                'password' => Hash::make('ega123'),
                'role' => 'kasir',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pembeli@gmail.com'],
            [
                'name' => 'egapembeli',
                'password' => Hash::make('pembeli123'),
                'role' => 'pembeli',
            ]
        );
    }
}
