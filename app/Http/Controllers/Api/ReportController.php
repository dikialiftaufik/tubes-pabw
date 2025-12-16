<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Mengambil data report dalam format JSON
    public function index()
    {
        // Sesuaikan query dengan ReportController yang asli
        // Pastikan relasi 'user' dan 'detailPesanan.menu' ada di model Pesanan
        $salesData = Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status_pesanan', 'Selesai') // Menggunakan 'status_pesanan' sesuai perbaikan SQL sebelumnya
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Laporan Penjualan',
            'data' => $salesData
        ], 200);
    }

    // Export Excel via API
    public function exportExcel()
    {
        $salesData = Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status_pesanan', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(new SalesReportExport($salesData), 'laporan_penjualan_api.xlsx');
    }

    // Export PDF via API
    public function exportPdf()
    {
        $salesData = Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status_pesanan', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Menggunakan view yang sama dengan web agar tampilan konsisten
        $pdf = Pdf::loadView('admin.reports_pdf', compact('salesData'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_penjualan_api.pdf');
    }
}