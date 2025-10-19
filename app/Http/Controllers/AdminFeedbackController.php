<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    /**
     * Menampilkan halaman manajemen feedback.
     */
    public function index()
    {
        // Data dummy untuk umpan balik dari pelanggan
        $feedbackData = [
            [
                'id' => 1,
                'nama_user' => 'Budi Santoso',
                'judul' => 'Saran untuk Area Parkir',
                'pesan' => 'Area parkir di malam hari agak gelap, mungkin bisa ditambahkan beberapa lampu lagi untuk keamanan dan kenyamanan pengunjung. Terima kasih.',
                'tanggal' => '2025-10-18 20:30:15',
            ],
            [
                'id' => 2,
                'nama_user' => 'Citra Lestari',
                'judul' => 'Menu Vegetarian Kurang Bervariasi',
                'pesan' => 'Saya suka suasana restorannya, tapi pilihan untuk menu vegetarian sangat terbatas. Semoga ke depannya bisa ditambah variasi menu sehat lainnya.',
                'tanggal' => '2025-10-17 14:12:45',
            ],
            [
                'id' => 3,
                'nama_user' => 'Doni Firmansyah',
                'judul' => 'Musik Terlalu Keras',
                'pesan' => 'Kemarin saat live music, volume suaranya terlalu keras sehingga sulit untuk mengobrol dengan teman. Mungkin bisa sedikit disesuaikan volumenya.',
                'tanggal' => '2025-10-16 21:05:00',
            ],
            [
                'id' => 4,
                'nama_user' => 'Ani Wijaya',
                'judul' => 'Pelayanan Sangat Memuaskan!',
                'pesan' => 'Hanya ingin mengucapkan terima kasih atas pelayanan yang luar biasa dari staf bernama Rian. Sangat ramah dan cekatan. Makanan juga enak!',
                'tanggal' => '2025-10-15 19:55:23',
            ],
            [
                'id' => 5,
                'nama_user' => 'Fajar Nugraha',
                'judul' => 'Kebersihan Toilet Perlu Ditingkatkan',
                'pesan' => 'Secara umum restoran sudah bersih, namun kemarin saat saya ke toilet, kondisinya kurang terawat. Mohon menjadi perhatian.',
                'tanggal' => '2025-10-14 12:30:11',
            ],
        ];

        return view('admin.feedback', ['feedbackData' => $feedbackData]);
    }
}
