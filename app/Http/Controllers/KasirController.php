<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Reservation;
use App\Models\Menu;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.index');
    }

    public function stok()
    {
        $menus = Menu::all();
        return view('kasir.stok', compact('menus'));
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->stok = $request->stok;
        $menu->save();

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function pesanan()
    {
        $pesanan = Pesanan::with(['user', 'detail.menu'])->get();
        return view('kasir.status-pesanan', compact('pesanan'));
    }

    public function reservasi()
    {
        $reservasi = Reservation::latest()->get();
        return view('kasir.status-reservasi', compact('reservasi'));
    }
}
