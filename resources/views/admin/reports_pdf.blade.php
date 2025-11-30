<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f2f2f2; padding: 8px; }
        td { padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="text-center">Laporan Penjualan The Komar's</h2>
    <p class="text-center">Dicetak Tanggal: {{ date('d-m-Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Pelanggan</th>
                <th>Item</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesData as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                <td>INV-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $row->user->name ?? 'Guest' }}</td>
                <td>
                    <ul style="padding-left: 15px; margin: 0;">
                    @foreach($row->detailPesanan as $detail)
                        <li>{{ $detail->menu->nama ?? 'Menu Hapus' }} ({{ $detail->jumlah }})</li>
                    @endforeach
                    </ul>
                </td>
                <td class="text-right">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($salesData->sum('total_harga'), 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>