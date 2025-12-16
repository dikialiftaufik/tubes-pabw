<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik sederhana untuk dashboard
        $data = [
            'total_menu' => Menu::count(),
            'total_pesanan' => Pesanan::count(),
            'total_pembeli' => User::where('role', 'pembeli')->count(),
            'pendapatan_total' => Pesanan::where('status_pesanan', 'Selesai')->sum('total_harga')
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data Dashboard Admin',
            'data' => $data
        ], 200);
    }
}