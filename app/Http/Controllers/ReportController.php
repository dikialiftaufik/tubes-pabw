<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Exports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Method Private untuk mengambil data yang SAMA untuk View, Excel, dan PDF
    private function getSalesData()
    {
        return Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status', 'Selesai') 
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function salesReport()
    {
        $salesData = $this->getSalesData();
        return view('admin.reports', compact('salesData'));
    }

    public function exportExcel()
    {
        $data = $this->getSalesData();
        return Excel::download(new SalesReportExport($data), 'laporan_penjualan_'.date('Y-m-d').'.xlsx');
    }

    public function exportPdf()
    {
        $salesData = $this->getSalesData();
        $pdf = Pdf::loadView('admin.reports_pdf', compact('salesData'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('laporan_penjualan_'.date('Y-m-d').'.pdf');
    }
}