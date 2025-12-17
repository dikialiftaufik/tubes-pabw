<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Reservation; 
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function pesanan()
    {
        // PERBAIKAN: Gunakan 'id_user' sesuai database baru
        $pesanan = Pesanan::where('id_user', Auth::id())
            ->with('detailPesanan.menu') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat_pesanan', compact('pesanan'));
    }

    public function reservasi()
    {
        // PERBAIKAN: Cek tabel reservasi juga, biasanya id_user juga
        $reservasi = Reservation::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat_reservasi', compact('reservasi')); // Pastikan view ini ada
    }
}