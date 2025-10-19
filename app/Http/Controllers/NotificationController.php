<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Menampilkan halaman manajemen notifikasi.
     */
    public function index()
    {
        // Data dummy untuk notifikasi operasional restoran
        $notifications = [
            [
                'id' => 1,
                'gambar' => 'https://placehold.co/100x100/7d3cff/white?text=Musik',
                'judul' => 'Jadwal Live Music Pekan Ini',
                'pesan' => 'Nikmati alunan musik akustik dari "Senja Band" setiap Jumat malam, mulai pukul 19.00 WIB.',
                'status' => 'Published',
            ],
            [
                'id' => 2,
                'gambar' => 'https://placehold.co/100x100/28a745/white?text=Bersih',
                'judul' => 'Penyemprotan Disinfektan Rutin',
                'pesan' => 'Untuk kenyamanan bersama, kami akan melakukan sterilisasi area pada hari Rabu, 22 Okt 2025, pukul 08.00 - 10.00 WIB. Restoran akan buka setelahnya.',
                'status' => 'Published',
            ],
            [
                'id' => 3,
                'gambar' => 'https://placehold.co/100x100/ffc107/white?text=Puasa',
                'judul' => 'Penyesuaian Jadwal Bulan Puasa',
                'pesan' => 'Selama bulan suci Ramadhan, kami akan buka mulai pukul 15.00 WIB dan menyediakan paket berbuka puasa spesial.',
                'status' => 'Draft',
            ],
            [
                'id' => 4,
                'gambar' => 'https://placehold.co/100x100/dc3545/white?text=Tutup',
                'judul' => 'Informasi Libur Lebaran',
                'pesan' => 'Restoran akan tutup sementara untuk libur Idul Fitri mulai tanggal 29 April hingga 4 Mei 2026. Selamat merayakan hari kemenangan!',
                'status' => 'Published',
            ],
            [
                'id' => 5,
                'gambar' => 'https://placehold.co/100x100/17a2b8/white?text=Promo',
                'judul' => 'Promo Spesial Hari Kemerdekaan',
                'pesan' => 'Dapatkan diskon 17% untuk semua menu makanan pada tanggal 17 Agustus. Tunjukkan semangat merah putihmu!',
                'status' => 'Draft',
            ],
        ];

        return view('admin.notifications', ['notifications' => $notifications]);
    }
}
