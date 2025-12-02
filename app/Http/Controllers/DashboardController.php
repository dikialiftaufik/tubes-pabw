<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Reservation; // Pastikan Model Reservation ada (sesuai tabel reservations)

class DashboardController extends Controller
{
    public function index()
    {
        
        // Hitung total pendapatan (Hanya dari pesanan yang statusnya 'Selesai')
        $totalPendapatan = Pesanan::where('status', 'Selesai')->sum('total_harga');

        // Hitung total pesanan (Semua status)
        $totalPesanan = Pesanan::count();

        // Hitung total reservasi (Dari tabel reservations)
        $totalReservasi = DB::table('reservations')->count(); 

        // Hitung pelanggan baru (User dengan role pembeli yang daftar bulan ini)
        $pelangganBaru = User::where('role', 'pembeli')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $statistik = [
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan' => $totalPesanan,
            'totalReservasi' => $totalReservasi,
            'pelangganBaru' => $pelangganBaru,
        ];

        $labelsPendapatan = [];
        $dataPendapatan = [];

        for ($i = 6; $i >= 0; $i--) {
            // Ambil tanggal mundur dari hari ini
            $date = Carbon::now()->subDays($i);
            
            // Format label grafik (misal: 19 Oct)
            $labelsPendapatan[] = $date->format('d M');

            // Query Sum Total Harga per tanggal tersebut
            $income = Pesanan::whereDate('tanggal', $date->format('Y-m-d'))
                ->where('status', 'Selesai') // Hanya hitung yang selesai
                ->sum('total_harga');
            
            $dataPendapatan[] = $income;
        }

        // Query menggunakan Join antara detail_pesanan dan menu
        $topMenus = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.menu_id', '=', 'menu.id')
            ->select('menu.nama', DB::raw('SUM(detail_pesanan.jumlah) as total_jual'))
            ->groupBy('menu.id', 'menu.nama')
            ->orderByDesc('total_jual')
            ->limit(5) // Ambil top 5
            ->get();

        // Pisahkan hasil query ke array terpisah untuk Chart.js
        $menuLabels = $topMenus->pluck('nama')->toArray();
        $menuData = $topMenus->pluck('total_jual')->toArray();

        $menuTerlaris = [
            'labels' => $menuLabels,
            'data' => $menuData
        ];

        return view('admin.dashboard', [
            'statistik' => $statistik,
            'labelsPendapatan' => $labelsPendapatan,
            'dataPendapatan' => $dataPendapatan,
            'menuTerlaris' => $menuTerlaris,
        ]);
    }
}