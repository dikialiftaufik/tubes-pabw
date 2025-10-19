@extends('adminlte::page')

@section('title', 'Laporan Penjualan')

@section('content_header')
    <h1 class="m-0 text-dark">Laporan Penjualan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{-- Filter dan Kontrol --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="col-md-5">
                        <label for="startDate">Dari Tanggal:</label>
                        <input type="date" id="startDate" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-5">
                        <label for="endDate">Sampai Tanggal:</label>
                        <input type="date" id="endDate" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-sm" style="width: 100%;">Tampilkan</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="table-responsive">
            <table id="sales-report-table" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Item Terjual</th>
                        <th>Pembayaran</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesData as $data)
                        <tr>
                            <td class="text-center">{{ \Carbon\Carbon::parse($data['tanggal'])->format('d M Y') }}</td>
                            <td>{{ $data['invoice'] }}</td>
                            <td>{{ $data['pelanggan'] }}</td>
                            <td>{{ $data['item'] }}</td>
                            <td class="text-center">{{ $data['metode_pembayaran'] }}</td>
                            <td class="text-right">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($data['status'] == 'Lunas')
                                    <span class="badge badge-success">{{ $data['status'] }}</span>
                                @elseif($data['status'] == 'Batal')
                                    <span class="badge badge-danger">{{ $data['status'] }}</span>
                                @else
                                    <span class="badge badge-warning">{{ $data['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#sales-report-table').DataTable({
            // Konfigurasi DOM untuk menata letak elemen
            // B = Buttons, f = filter (search), r = processing, t = table, i = info, p = pagination
            dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            // Konfigurasi tombol ekspor
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Export Excel',
                    className: 'btn btn-success btn-sm',
                    title: 'Laporan Penjualan - {{ now()->format("d M Y") }}'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'Laporan Penjualan - {{ now()->format("d M Y") }}',
                    orientation: 'landscape', // Ubah ke landscape agar lebih lebar
                    pageSize: 'A4'
                }
            ],
            
            // Menerjemahkan DataTables ke Bahasa Indonesia
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data yang cocok",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total entri)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
            },
        });
    });
</script>
@stop

