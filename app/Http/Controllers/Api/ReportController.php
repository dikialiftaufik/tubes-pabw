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
    private function getSalesData()
    {
        return Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('status_pesanan', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function index()
    {
        $data = $this->getSalesData();
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function exportExcel()
    {
        $data = $this->getSalesData();
        return Excel::download(new SalesReportExport($data), 'laporan_penjualan_api.xlsx');
    }

    public function exportPdf()
    {
        $salesData = $this->getSalesData();
        $pdf = Pdf::loadView('admin.reports_pdf', compact('salesData'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('laporan_penjualan_api.pdf');
    }
}