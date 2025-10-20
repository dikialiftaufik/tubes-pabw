<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    // Menampilkan laman utama kasir
    public function index()
    {
        // Karena file view kamu bernama kasir.blade.php dan bukan kasir/index.blade.php
        return view('Kasir.index');

    }

    // Fungsi dummy untuk tombol "Perbarui Stok" (belum terhubung ke database)
    public function updateStok(Request $request)
    {
        // Nanti ini bisa diisi logika update stok ke database
        // Tapi sekarang cukup redirect kembali ke halaman kasir dengan pesan sukses
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}
