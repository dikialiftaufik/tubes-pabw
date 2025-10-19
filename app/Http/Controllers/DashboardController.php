<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Small Box
        $statistik = [
            'totalPendapatan' => 530000,
            'totalPesanan' => 120,
            'totalReservasi' => 45,
            'pelangganBaru' => 15,
        ];

        // Data untuk Grafik Pendapatan 7 Hari Terakhir (Line Chart)
        $labelsPendapatan = [];
        $dataPendapatan = [];
        for ($i = 6; $i >= 0; $i--) {
            $labelsPendapatan[] = date('d M', strtotime("-$i days"));
            $dataPendapatan[] = rand(100000, 500000);
        }

        // --- DATA BARU UNTUK GRAFIK MENU TERLARIS (PIE CHART) ---
        $menuTerlaris = [
            'labels' => ['Sate Ayam', 'Tongseng', 'Nasi Goreng', 'Tengkleng', 'Gule'],
            'data' => [
                rand(30, 80), // Jumlah porsi Sate Ayam terjual
                rand(20, 60), // Jumlah porsi Tongseng terjual
                rand(40, 90), // Jumlah porsi Nasi Goreng terjual
                rand(15, 50), // Jumlah porsi Tengkleng terjual
                rand(10, 40), // Jumlah porsi Gule terjual
            ],
        ];


        // Mengirim semua data ke view
        return view('admin.dashboard', [
            'statistik' => $statistik,
            'labelsPendapatan' => $labelsPendapatan,
            'dataPendapatan' => $dataPendapatan,
            'menuTerlaris' => $menuTerlaris,
        ]);
    }
}

