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
        $user = $request->user();
        
        // Proteksi ganda jika middleware tembus (sesuai modul AccessController)
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Akses hanya untuk admin!'], 403);
        }

        $totalPendapatan = Pesanan::where('status', 'selesai')->sum('total_harga');
        $totalPesanan = Pesanan::count();
        $totalMenu = Menu::count();
        $totalUser = User::where('role', 'user')->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_pendapatan' => $totalPendapatan,
                'total_pesanan' => $totalPesanan,
                'total_menu' => $totalMenu,
                'total_user' => $totalUser
            ]
        ]);
    }
}