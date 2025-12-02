<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeeddbackSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('feeddback')->insert([
            [
                'nama' => 'User',
                'judul' => 'Pelayanan Bagus',
                'pesan' => 'Pelayanan ramah dan makanan datang cepat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dedi Saputra',
                'judul' => 'Lampu Meja Redup',
                'pesan' => 'Saran: lampu meja nomor 5 agak redup dan perlu diperbaiki.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Anonim',
                'judul' => 'Tempat Nyaman',
                'pesan' => 'Tempatnya nyaman, cocok untuk makan keluarga.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Agus',
                'judul' => 'Menu Enak',
                'pesan' => 'Menu ayam bakarnya enak banget, recommended!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
