<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        DB::table('reservations')->insert([
    [
        'user_id' => 1,
        'name' => 'Budi Santoso',
        'time' => '18:00',
        'date' => '2025-01-12',
        'people' => 2,
        'message' => 'Pesan tempat dekat jendela',
        'status' => 'pending',
    ],
    [
        'user_id' => 2,
        'name' => 'Siti Aisyah',
        'time' => '19:30',
        'date' => '2025-01-15',
        'people' => 4,
        'message' => 'Acara ulang tahun',
        'status' => 'confirmed',
    ],
    [
        'user_id' => 1,
        'name' => 'Andi Wijaya',
        'time' => '17:00',
        'date' => '2025-01-20',
        'people' => 3,
        'message' => 'Tidak ada catatan',
        'status' => 'cancelled',
    ],
    [
        'user_id' => 3,
        'name' => 'Rina Oktavia',
        'time' => '20:00',
        'date' => '2025-02-03',
        'people' => 2,
        'message' => 'Ingin meja outdoor',
        'status' => 'pending',
    ],
    [
        'user_id' => 4,
        'name' => 'Dedi Pratama',
        'time' => '18:30',
        'date' => '2025-02-10',
        'people' => 5,
        'message' => 'Minta kursi tambahan',
        'status' => 'confirmed',
    ],
    ]);
    }
}
