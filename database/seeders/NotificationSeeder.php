<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua user dengan role pembeli
        $pembeliUsers = User::where('role', 'pembeli')->get();

        // Notifikasi umum untuk semua pembeli
        $notifications = [
            [
                'judul_notifikasi' => 'Selamat Datang!',
                'pesan_notifikasi' => 'Selamat datang di The Komar\'s! Nikmati berbagai menu lezat kami.',
            ],
            [
                'judul_notifikasi' => 'Promo Spesial Bulan Ini',
                'pesan_notifikasi' => 'Nikmati promo hemat hingga 50% untuk menu Tengkleng Kambing dan Tongseng Ayam.',
            ],
            [
                'judul_notifikasi' => 'Menu Baru Telah Hadir',
                'pesan_notifikasi' => 'Kami menambahkan beberapa menu baru yang wajib kamu coba! Cek menu untuk detailnya.',
            ],
            [
                'judul_notifikasi' => 'Informasi Reservasi',
                'pesan_notifikasi' => 'Sekarang reservasi meja bisa dilakukan lebih mudah melalui website. Pesan sekarang!',
            ],
            [
                'judul_notifikasi' => 'Jam Operasional Update',
                'pesan_notifikasi' => 'Restoran kini buka setiap hari pukul 10.00 - 23.00 WIB. Sampai jumpa!',
            ],
            [
                'judul_notifikasi' => 'Reservasi Dikonfirmasi',
                'pesan_notifikasi' => 'Reservasi Anda untuk tanggal 2025-12-15 jam 19:00 telah DIKONFIRMASI. Terima kasih!',
            ],
            [
                'judul_notifikasi' => 'Pesanan Siap',
                'pesan_notifikasi' => 'Pesanan Anda sedang disiapkan. Pesanan akan segera diantar ke meja Anda.',
            ],
        ];

        // Tambahkan notifikasi untuk setiap pembeli
        foreach ($pembeliUsers as $user) {
            foreach ($notifications as $notif) {
                Notifikasi::create([
                    'id_user'           => $user->id,
                    'judul_notifikasi'  => $notif['judul_notifikasi'],
                    'pesan_notifikasi'  => $notif['pesan_notifikasi'],
                ]);
            }
        }

        // Jika tidak ada pembeli, buat notifikasi untuk user pertama
        if ($pembeliUsers->isEmpty()) {
            $user = User::first();
            if ($user) {
                foreach ($notifications as $notif) {
                    Notifikasi::create([
                        'id_user'           => $user->id,
                        'judul_notifikasi'  => $notif['judul_notifikasi'],
                        'pesan_notifikasi'  => $notif['pesan_notifikasi'],
                    ]);
                }
            }
        }
    }
}

