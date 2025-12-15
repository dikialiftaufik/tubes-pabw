<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Mengambil data penjualan yang sudah selesai.
     */
    private function getSalesData()
    {
        return Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status', 'Selesai') 
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Menampilkan halaman laporan penjualan.
     * Method ini sebelumnya bernama 'salesReport', diubah menjadi 'index'
     * agar sesuai dengan panggilan route di web.php.
     */
    public function index()
    {
        $salesData = $this->getSalesData();
        return view('admin.reports', compact('salesData'));
    }

    /**
     * Export laporan ke Excel.
     */
    public function exportExcel()
    {
        $data = $this->getSalesData();
        // Pastikan nama file unik dengan timestamp
        return Excel::download(new SalesReportExport($data), 'laporan_penjualan_'.date('Y-m-d_H-i-s').'.xlsx');
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf()
    {
        $salesData = $this->getSalesData();
        
        // Load view khusus PDF
        $pdf = Pdf::loadView('admin.reports_pdf', compact('salesData'));
        
        // Set ukuran kertas
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_penjualan_'.date('Y-m-d_H-i-s').'.pdf');
    }
}