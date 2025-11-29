<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'user_id' => 1,
                'pesan' => 'Reservasi Anda telah diterima',
                'status' => 'unread'
            ],
            [
                'user_id' => 2,
                'pesan' => 'Reservasi Anda dikonfirmasi',
                'status' => 'read'
            ],
            [
                'user_id' => 3,
                'pesan' => 'Ada perubahan pada reservasi Anda',
                'status' => 'unread'
            ],
            [
                'user_id' => 1,
                'pesan' => 'Reservasi dibatalkan',
                'status' => 'read'
            ],
            [
                'user_id' => 4,
                'pesan' => 'Terima kasih telah menggunakan layanan kami',
                'status' => 'unread'
            ],
        ]);
    }
}
