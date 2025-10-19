<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu untuk user/pengunjung.
     */
    public function index()
    {
        // Data menu baru sesuai dengan permintaan
        $menuMakanan = [
            [
                'id' => 1,
                'nama' => 'Nasi Goreng',
                'deskripsi' => 'Nasi goreng khas Indonesia dengan bumbu rempah dan topping pilihan seperti telur, ayam suwir, dan acar segar.',
                'harga' => 22000,
                'gambar' => asset('img/menu/nasi-goreng.jpg'),
            ],
            [
                'id' => 2,
                'nama' => 'Sate Ayam',
                'deskripsi' => 'Sate ayam dengan bumbu kacang gurih dan kecap manis khas, disajikan dengan lontong.',
                'harga' => 25000,
                'gambar' => asset('img/menu/sate-ayam.jpg'),
            ],
            [
                'id' => 3,
                'nama' => 'Sate Kambing',
                'deskripsi' => 'Sate kambing empuk dengan bumbu kecap manis, irisan bawang merah, dan cabai rawit.',
                'harga' => 35000,
                'gambar' => asset('img/menu/sate-kambing.jpg'),
            ],
            [
                'id' => 4,
                'nama' => 'Sate Sapi',
                'deskripsi' => 'Potongan daging sapi pilihan dibakar dengan bumbu kecap pedas manis, disajikan dengan lontong.',
                'harga' => 32000,
                'gambar' => asset('img/menu/sate-sapi.jpg'),
            ],
            [
                'id' => 5,
                'nama' => 'Tengkleng Kambing',
                'deskripsi' => 'Tengkleng kambing khas Jawa dengan kuah gurih pedas dari rempah-rempah tradisional.',
                'harga' => 42000,
                'gambar' => asset('img/menu/tengkleng-kambing.jpg'),
            ],
            [
                'id' => 6,
                'nama' => 'Tongseng Ayam',
                'deskripsi' => 'Tongseng ayam dengan kuah santan kental dan cita rasa rempah khas, disajikan panas.',
                'harga' => 28000,
                'gambar' => asset('img/menu/tongseng-ayam.jpg'),
            ],
            [
                'id' => 7,
                'nama' => 'Tongseng Kambing',
                'deskripsi' => 'Tongseng kambing dengan potongan daging muda, kuah gurih pedas, dan sayuran segar.',
                'harga' => 38000,
                'gambar' => asset('img/menu/tongseng-kambing.jpg'),
            ],
            [
                'id' => 8,
                'nama' => 'Tongseng Kering Sapi',
                'deskripsi' => 'Versi kering dari tongseng sapi tanpa kuah, dimasak dengan bumbu manis pedas yang meresap.',
                'harga' => 33000,
                'gambar' => asset('img/menu/tongseng-kering-sapi.jpg'),
            ],
            [
                'id' => 9,
                'nama' => 'Tongseng Sapi',
                'deskripsi' => 'Tongseng sapi dengan kuah santan gurih dan aroma rempah menggugah selera.',
                'harga' => 34000,
                'gambar' => asset('img/menu/tongseng-sapi.jpg'),
            ],
        ];

        // Mengirim data ke view. Nama variabel di sini 'menuData' harus cocok dengan yang ada di file blade.
        return view('menu', ['menuMakanan' => $menuMakanan]);
    }
}

