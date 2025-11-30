<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailPesanan;

class DetailPesananSeeder extends Seeder
{
    public function run(): void
    {
        DetailPesanan::create([
            'pesanan_id' => 1,
            'menu_id' => 1,
            'jumlah' => 2,
            'subtotal' => 30000
        ]);

        DetailPesanan::create([
            'pesanan_id' => 1,
            'menu_id' => 3,
            'jumlah' => 1,
            'subtotal' => 15000
        ]);

        DetailPesanan::create([
            'pesanan_id' => 2,
            'menu_id' => 2,
            'jumlah' => 1,
            'subtotal' => 70000
        ]);
    }
}
