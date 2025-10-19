<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan penjualan dengan data yang lebih realistis.
     */
    public function salesReport()
    {
        // Data dummy yang lebih detail dan relevan untuk laporan di dunia nyata
        $salesData = [
            ['tanggal' => '2025-10-19', 'invoice' => 'INV-001', 'pelanggan' => 'Budi Santoso', 'item' => 'Sate Ayam (2), Es Teh Manis (2)', 'metode_pembayaran' => 'QRIS', 'total' => 70000, 'status' => 'Lunas'],
            ['tanggal' => '2025-10-19', 'invoice' => 'INV-002', 'pelanggan' => 'Ani Wijaya', 'item' => 'Nasi Goreng Spesial (1)', 'metode_pembayaran' => 'Tunai', 'total' => 25000, 'status' => 'Lunas'],
            ['tanggal' => '2025-10-18', 'invoice' => 'INV-003', 'pelanggan' => 'Citra Lestari', 'item' => 'Tongseng (1), Tengkleng (1), Jus Alpukat (2)', 'metode_pembayaran' => 'Debit', 'total' => 95000, 'status' => 'Lunas'],
            ['tanggal' => '2025-10-18', 'invoice' => 'INV-004', 'pelanggan' => 'Doni Firmansyah', 'item' => 'Gule (1)', 'metode_pembayaran' => 'Tunai', 'total' => 30000, 'status' => 'Batal'],
            ['tanggal' => '2025-10-18', 'invoice' => 'INV-005', 'pelanggan' => 'Eka Putri', 'item' => 'Sate Ayam (5), Lontong (5)', 'metode_pembayaran' => 'QRIS', 'total' => 150000, 'status' => 'Lunas'],
            ['tanggal' => '2025-10-17', 'invoice' => 'INV-006', 'pelanggan' => 'Fajar Nugraha', 'item' => 'Nasi Goreng (2), Es Jeruk (2)', 'metode_pembayaran' => 'Tunai', 'total' => 60000, 'status' => 'Lunas'],
            ['tanggal' => '2025-10-17', 'invoice' => 'INV-007', 'pelanggan' => 'Gita Permata', 'item' => 'Tengkleng (1)', 'metode_pembayaran' => 'Debit', 'total' => 40000, 'status' => 'Lunas'],
        ];

        return view('admin.reports', ['salesData' => $salesData]);
    }
}

