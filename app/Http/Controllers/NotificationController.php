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
                'gambar' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=1200&q=80&auto=format&fit=crop',
                'judul' => 'Jadwal Live Music Pekan Ini',
                'pesan' => 'Nikmati alunan musik akustik dari "Senja Band" setiap Jumat malam, mulai pukul 19.00 WIB.',
                'status' => 'Published',
            ],
            [
                'id' => 2,
                'gambar' => 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Bersih Bersih',
                'judul' => 'Penyemprotan Disinfektan Rutin',
                'pesan' => 'Untuk kenyamanan bersama, kami akan melakukan sterilisasi area pada hari Rabu, 22 Okt 2025, pukul 08.00 - 10.00 WIB. Restoran akan buka setelahnya.',
                'status' => 'Published',
            ],
            [
                'id' => 3,
                'gambar' => 'https://asset-2.tstatic.net/belitung/foto/bank/images/20241024-Puasa-2025.jpg',
                'judul' => 'Penyesuaian Jadwal Bulan Puasa',
                'pesan' => 'Selama bulan suci Ramadhan, kami akan buka mulai pukul 15.00 WIB dan menyediakan paket berbuka puasa spesial.',
                'status' => 'Draft',
            ],
            [
                'id' => 4,
                'gambar' => 'https://www.djkn.kemenkeu.go.id/files/images/2022/05/5161272.jpg',
                'judul' => 'Informasi Libur Lebaran',
                'pesan' => 'Restoran akan tutup sementara untuk libur Idul Fitri mulai tanggal 29 April hingga 4 Mei 2026. Selamat merayakan hari kemenangan!',
                'status' => 'Published',
            ],
            [
                'id' => 5,
                'gambar' => 'https://media.istockphoto.com/id/1051833088/id/vektor/17-agustus-ikon-kalender.jpg?s=612x612&w=is&k=20&c=_GAgy8SGWdcZMK41K48WhIdYrEw_4ngv1Xu2UvVNpdM=',
                'judul' => 'Promo Spesial Hari Kemerdekaan',
                'pesan' => 'Dapatkan diskon 17% untuk semua menu makanan pada tanggal 17 Agustus. Tunjukkan semangat merah putihmu!',
                'status' => 'Draft',
            ],
        ];

        return view('admin.notifications', ['notifications' => $notifications]);
    }
}
