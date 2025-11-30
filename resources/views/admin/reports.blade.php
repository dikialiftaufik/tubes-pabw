@extends('adminlte::page')

@section('title', 'Laporan Penjualan')

@section('content_header')
    <h1>Laporan Penjualan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Transaksi Selesai</h3>
            <div class="card-tools">
                <a href="{{ route('admin.reports.export_excel') }}" class="btn btn-success btn-sm" target="_blank">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('admin.reports.export_pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="reportsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 15%">Tanggal</th>
                        <th style="width: 15%">Invoice</th>
                        <th style="width: 20%">Pelanggan</th>
                        <th style="width: 30%">Item Pesanan</th>
                        <th style="width: 15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesData as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->created_at->format('d M Y H:i') }}</td>
                        <td>INV-{{ str_pad($row->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $row->user ? $row->user->name : 'Guest' }}</td>
                        <td>
                            <ul class="pl-3 mb-0 small">
                                @foreach($row->detailPesanan as $detail)
                                    <li>
                                        {{ $detail->menu->nama ?? 'Menu Terhapus' }} 
                                        <span class="text-muted">(x{{ $detail->jumlah }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#reportsTable').DataTable({
                "responsive": true,
                "order": [[ 1, "desc" ]]
            });
        });
    </script>
@stop