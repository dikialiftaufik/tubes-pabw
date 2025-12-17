<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Menu;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Hitung Total Pendapatan
        // SQL: Kolom 'status_pesanan' dan 'total_hrg'. Value di SQL Dump adalah 'Selesai' (Kapital S)
        $pendapatan = Pesanan::where('status_pesanan', 'Selesai')->sum('total_hrg');

        // 2. Hitung Total Pesanan
        $jumlah_pesanan = Pesanan::count();

        // 3. Hitung Total Menu
        $jumlah_menu = Menu::count();

        // 4. Hitung Total Pelanggan
        // SQL: Role di tabel users adalah 'pembeli', bukan 'user'
        $jumlah_user = User::where('role', 'pembeli')->count();

        $data = [
            'total_pendapatan' => $pendapatan,
            'total_pesanan' => $jumlah_pesanan,
            'total_menu' => $jumlah_menu,
            'total_user' => $jumlah_user
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}