<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Feedback; // Jika modelnya bernama Feedback (sesuai sql)

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung data untuk dashboard
        $totalMenu = Menu::count();
        $totalPesanan = Pesanan::count();
        $totalUser = User::where('role', 'pembeli')->count();
        // Sesuaikan nama tabel feedback jika berbeda, di sql tertulis 'feedback'
        $totalFeedback = \DB::table('feedback')->count(); 

        return response()->json([
            'success' => true,
            'message' => 'Data Dashboard Admin',
            'data' => [
                'total_menu' => $totalMenu,
                'total_pesanan' => $totalPesanan,
                'total_pembeli' => $totalUser,
                'total_feedback' => $totalFeedback
            ]
        ], 200);
    }
}