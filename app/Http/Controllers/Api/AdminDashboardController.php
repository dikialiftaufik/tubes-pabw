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
        $pendapatan = Pesanan::where('status_pesanan', 'Selesai')->sum('total_hrg');

        $jumlah_pesanan = Pesanan::count();

        $jumlah_menu = Menu::count();

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