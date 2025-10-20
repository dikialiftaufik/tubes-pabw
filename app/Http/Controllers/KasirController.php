<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    
    public function index()
    {
        
        $menus = [
            ['nama' => 'Sate Ayam', 'stok' => 10, 'gambar' => 'img/menu/sate-ayam.jpg'],
            ['nama' => 'Sate Sapi', 'stok' => 8, 'gambar' => 'img/menu/sate-sapi.jpg'],
            ['nama' => 'Sate Kambing', 'stok' => 5, 'gambar' => 'img/menu/sate-kambing.jpg'],
            ['nama' => 'Tongseng Ayam', 'stok' => 7, 'gambar' => 'img/menu/tongseng-ayam.jpg'],
            ['nama' => 'Tongseng Sapi', 'stok' => 6, 'gambar' => 'img/menu/tongseng-sapi.jpg'],
            ['nama' => 'Tongseng Kambing', 'stok' => 4, 'gambar' => 'img/menu/tongseng-kambing.jpg'],
        ];

        
        $pesanan = [
            ['nama' => 'Rina', 'menu' => 'Sate Ayam', 'jumlah' => 2, 'status' => 'Sedang Dibuat'],
            ['nama' => 'Budi', 'menu' => 'Tongseng Sapi', 'jumlah' => 1, 'status' => 'Selesai'],
            ['nama' => 'Dewi', 'menu' => 'Sate Kambing', 'jumlah' => 3, 'status' => 'Sedang Dibuat'],
        ];

        // Kirim data ke view
        return view('kasir.index', compact('menus', 'pesanan'));
    }

    
    public function updateStok(Request $request)
    {
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}
