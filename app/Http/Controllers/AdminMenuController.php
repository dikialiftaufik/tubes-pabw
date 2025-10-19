<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    /**
     * Menampilkan halaman manajemen menu di sisi admin.
     */
    public function index()
    {
        // Menggunakan data yang sama persis dengan halaman menu user
        // Nantinya, data ini akan diambil dari database.
        $menuMakanan = [
            [
                'id' => 1,
                'nama' => 'Sate Ayam Spesial',
                'deskripsi' => 'Sate ayam dengan bumbu kacang khas, disajikan dengan lontong dan irisan bawang merah.',
                'harga' => 25000,
                'gambar' => 'https://placehold.co/600x400/FFC107/000000?text=Sate+Ayam',
            ],
            [
                'id' => 2,
                'nama' => 'Tengkleng Iga Sapi',
                'deskripsi' => 'Potongan iga sapi empuk yang dimasak dengan bumbu rempah kaya rasa, sedikit pedas.',
                'harga' => 45000,
                'gambar' => 'https://placehold.co/600x400/DC3545/FFFFFF?text=Tengkleng',
            ],
            [
                'id' => 3,
                'nama' => 'Nasi Goreng Nusantara',
                'deskripsi' => 'Nasi goreng klasik dengan campuran telur, ayam suwir, dan acar segar sebagai pelengkap.',
                'harga' => 22000,
                'gambar' => 'https://placehold.co/600x400/28A745/FFFFFF?text=Nasi+Goreng',
            ],
            [
                'id' => 4,
                'nama' => 'Tongseng Kambing',
                'deskripsi' => 'Daging kambing muda yang dimasak dalam kuah gulai panas dengan irisan kol dan tomat.',
                'harga' => 38000,
                'gambar' => 'https://placehold.co/600x400/17A2B8/FFFFFF?text=Tongseng',
            ],
            [
                'id' => 5,
                'nama' => 'Gado-Gado Siram',
                'deskripsi' => 'Sayuran segar direbus dan disajikan dengan saus kacang gurih, lengkap dengan kerupuk.',
                'harga' => 18000,
                'gambar' => 'https://placehold.co/600x400/6C757D/FFFFFF?text=Gado-Gado',
            ],
            [
                'id' => 6,
                'nama' => 'Soto Ayam Lamongan',
                'deskripsi' => 'Soto bening dengan suwiran ayam, soun, tauge, dan taburan koya yang membuatnya khas.',
                'harga' => 20000,
                'gambar' => 'https://placehold.co/600x400/FD7E14/000000?text=Soto+Ayam',
            ],
        ];

        // Untuk simulasi paginasi, kita hanya akan menampilkan beberapa data
        // dan membuat link paginasi statis.
        // Di aplikasi nyata, ini akan ditangani oleh Paginator Laravel.

        return view('admin.menu', compact('menuMakanan'));
    }
}
