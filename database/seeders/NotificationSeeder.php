<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Ambil user pertama (bisa kamu ubah ke user tertentu)
        $user = User::first();

        // 1. Notifikasi sambutan untuk user login
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Selamat Datang, ' . $user->name . '!',
                'message' => 'Hai ' . $user->name . ', senang bertemu lagi! Berikut beberapa info menarik untukmu.',
            ]);
        }

        // 2. Notifikasi umum (4 item)
        $notification = [
            [
                'title'   => 'Promo Spesial Bulan Ini',
                'message' => 'Nikmati promo hemat hingga 50% untuk menu tertentu.',
            ],
            [
                'title'   => 'Menu Baru Telah Hadir',
                'message' => 'Kami menambah beberapa menu baru yang wajib kamu coba!',
            ],
            [
                'title'   => 'Informasi Reservasi',
                'message' => 'Sekarang reservasi bisa dilakukan lebih mudah melalui website.',
            ],
            [
                'title'   => 'Jam Operasional Update',
                'message' => 'Restoran kini buka sampai pukul 23.00 WIB mulai minggu depan.',
            ],
        ];

        foreach ($notification as $notif) {
            Notification::create($notif);
        }
    }
}
