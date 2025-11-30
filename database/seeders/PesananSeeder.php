<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
   
    public function run(): void
    {
        Pesanan::create([
            'user_id' => 2, // contoh id user pembeli
            'tanggal' => now(),
            'total_harga' => 45000,
            'status' => 'Selesai'
        ]);

        Pesanan::create([
            'user_id' => 3,
            'tanggal' => now(),
            'total_harga' => 70000,
            'status' => 'Menunggu Pembayaran'
        ]);
    }
}
