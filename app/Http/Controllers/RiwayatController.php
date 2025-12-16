<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Reservation; // Pastikan model Reservation ada (Tugas Zufar)
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{

    public function pesanan()
    {
        // Ambil pesanan milik user yang sedang login saja dengan relasi detailPesanan dan menu
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->with('detailPesanan.menu') // Load relasi agar nama menu bisa ditampilkan
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat_pesanan', compact('pesanan'));
    }

    // No. 16: Riwayat Reservasi
    public function reservasi()
    {
        // Ambil reservasi milik user yang sedang login saja
        $reservasi = Reservation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat_reservasi', compact('reservasi'));
    }
}