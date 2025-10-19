<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu makanan untuk user.
     */
    public function index()
    {
        // Data menu makanan dalam bentuk array (tanpa database)
        $menuMakanan = [
            [
                'nama' => 'Sate Ayam',
                'deskripsi' => 'Sate ayam dengan bumbu kacang khas, disajikan dengan lontong dan irisan bawang merah.',
                'harga' => 25000,
                'gambar' => asset('img/menu/sate-ayam.jpg'),
            ],
            [
                'nama' => 'Tengkleng Iga Sapi',
                'deskripsi' => 'Potongan iga sapi empuk yang dimasak dengan bumbu rempah kaya rasa, sedikit pedas.',
                'harga' => 45000,
                'gambar' => asset('img/menu/tengkleng-kambing.jpg'),
            ],
            [
                'nama' => 'Nasi Goreng Nusantara',
                'deskripsi' => 'Nasi goreng klasik dengan campuran telur, ayam suwir, dan acar segar sebagai pelengkap.',
                'harga' => 22000,
                'gambar' => 'https://placehold.co/600x400/28A745/FFFFFF?text=Nasi+Goreng',
            ],
            [
                'nama' => 'Tongseng Kambing',
                'deskripsi' => 'Daging kambing muda yang dimasak dalam kuah gulai panas dengan irisan kol dan tomat.',
                'harga' => 38000,
                'gambar' => 'https://placehold.co/600x400/17A2B8/FFFFFF?text=Tongseng',
            ],
            [
                'nama' => 'Gado-Gado Siram',
                'deskripsi' => 'Sayuran segar direbus dan disajikan dengan saus kacang gurih, lengkap dengan kerupuk.',
                'harga' => 18000,
                'gambar' => 'https://placehold.co/600x400/6C757D/FFFFFF?text=Gado-Gado',
            ],
            [
                'nama' => 'Soto Ayam Lamongan',
                'deskripsi' => 'Soto bening dengan suwiran ayam, soun, tauge, dan taburan koya yang membuatnya khas.',
                'harga' => 20000,
                'gambar' => 'https://placehold.co/600x400/FD7E14/000000?text=Soto+Ayam',
            ],
        ];

        // Mengirim data ke view
        return view('menu', compact('menuMakanan'));
    }
}

