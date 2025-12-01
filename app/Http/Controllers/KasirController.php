<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;   
use App\Models\Reservation;
use App\Models\Menu;

class KasirController extends Controller
{
    // ==========================
    // DASHBOARD / HALAMAN UTAMA
    // ==========================
    public function index()
    {
        return view('kasir.index');
    }

    // ==========================
    // KELOLA STOK MENU
    // ==========================
    public function stok()
    {
        // Ambil semua menu dari database
        $menus = Menu::all();

        // Kirim ke view kasir/stok.blade.php
        return view('kasir.stok', compact('menus'));
    }

    public function updateStok(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->stok = $request->stok;
        $menu->save();

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    // ==========================
    // STATUS PESANAN
    // ==========================
    public function pesanan()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.menu'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.status-pesanan', compact('pesanan'));
    }

    // ==========================
    // STATUS RESERVASI
    // ==========================
    public function reservasi()
    {
        $reservasi = Reservation::orderBy('created_at', 'desc')->get();
        return view('kasir.status-reservasi', compact('reservasi'));
    }
}
