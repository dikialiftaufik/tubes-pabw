<?php

namespace App\Exports;

use App\Models\Pesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class SalesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * Mengambil data dari collection yang dikirim controller
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        // Kolom Metode dan Status DIHAPUS sesuai permintaan
        return [
            'Tanggal',
            'Invoice',
            'Pelanggan',
            'Item Pesanan',
            'Total Harga'
        ];
    }

    public function map($pesanan): array
    {
        // Format Item: "Nasi Goreng (2)"
        $items = $pesanan->detailPesanan->map(function($detail) {
            return ($detail->menu->nama ?? 'Menu Terhapus') . ' (x' . $detail->jumlah . ')';
        })->implode(', ');

        return [
            $pesanan->created_at->format('d-m-Y H:i'),
            'INV-' . str_pad($pesanan->id, 5, '0', STR_PAD_LEFT),
            $pesanan->user->name ?? 'Guest',
            $items,
            $pesanan->total_harga,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}