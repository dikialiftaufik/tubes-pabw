<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;   // pastikan file app/Models/Pesanan.php ada
use App\Models\Reservation;


class KasirController extends Controller
{
    public function index()
    {
        // tetap pakai dummy menus & pesanan ringan untuk halaman utama kasir (opsional)
        $menus = [
            ['nama' => 'Sate Ayam', 'stok' => 10, 'gambar' => 'img/menu/sate-ayam.jpg'],
            // ...
        ];

        $pesanan = [
            ['nama' => 'Rina', 'menu' => 'Sate Ayam', 'jumlah' => 2, 'status' => 'Sedang Dibuat'],
            // dummy untuk tampilan index (boleh dihapus nanti)
        ];

        return view('kasir.index', compact('menus', 'pesanan'));
    }

    public function updateStok(Request $request)
    {
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function dashboard()
    {
        return view('kasir.dashboard');
    }

    public function stok()
    {
        return view('kasir.stok');
    }

    // --- method pesanan : ambil data riil dari DB dan kirim ke view ---
    public function pesanan()
    {
        // ambil semua pesanan beserta relasi user (jika ada)
        // kalau kamu belum membuat relasi, ini tetap mengambil kolom dari tabel pesanan
        $pesanan = Pesanan::with('user')->orderBy('created_at', 'desc')->get();

        // kirim ke view kasir.status-pesanan
        return view('kasir.status-pesanan', compact('pesanan'));
    }

    // --- method reservasi : ambil data riil dari DB dan kirim ke view ---
   public function reservasi()
{
    $reservasi = Reservation::orderBy('created_at', 'desc')->get();

    return view('kasir.status-reservasi', compact('reservasi'));
}

}
