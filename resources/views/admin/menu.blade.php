@extends('adminlte::page')

@section('title', 'Manajemen Menu')

{{-- Menambahkan CSS untuk DataTables --}}
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@stop

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Menu Makanan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Menu Baru</a>

                    <table id="menu-table" class="table table-bordered table-striped table-hover" style="width:100%">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Menu</th>
                                <th style="width: 15%;">Gambar</th>
                                <th style="width: 12%;">Tipe</th>
                                <th style="width: 15%;">Harga</th>
                                <th style="width: 20%;">Deskripsi</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data 'tipe' ditambahkan di controller Anda --}}
                            {{-- 
    Kita langsung melakukan perulangan (looping) pada data asli '$menuMakanan' 
    yang dikirim dari Controller. Tidak perlu membuat variabel baru.
--}}
@foreach ($menuMakanan as $key => $item)
    <tr>
        {{-- Kolom untuk menampilkan nomor urut. '$key' dimulai dari 0, jadi kita tambah 1. --}}
        <td class="text-center align-middle">{{ $key + 1 }}</td>

        {{-- Kolom untuk menampilkan nama menu. --}}
        <td class="align-middle"><strong>{{ $item['nama'] }}</strong></td>

        {{-- Kolom untuk menampilkan gambar menu. --}}
        <td class="text-center align-middle">
            <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" class="img-fluid img-thumbnail" style="max-width: 150px; height: auto;" 
                 onerror="this.onerror=null;this.src='https://placehold.co/150x100/ced4da/6c757d?text=N/A';">
        </td>

        {{-- 
            Kolom untuk menampilkan tipe menu.
            Karena semua menu tipenya sama, kita bisa langsung tulis 'Main Course' di sini.
        --}}
        <td class="text-center align-middle">
            <span class="badge badge-success">Main Course</span>
        </td>

        {{-- Kolom untuk menampilkan harga, diformat agar mudah dibaca. --}}
        <td class="text-right align-middle">
            Rp {{ number_format($item['harga'], 0, ',', '.') }}
        </td>

        {{-- Kolom untuk menampilkan deskripsi, dipotong jika terlalu panjang. --}}
        <td class="align-middle">
            {{ Str::limit($item['deskripsi'], 50) }}
        </td>

        {{-- Kolom untuk tombol-tombol aksi (Lihat, Edit, Hapus). --}}
        <td class="text-center align-middle">
            <a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i></a>
            <a href="#" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit Menu"><i class="fas fa-edit"></i></a>
            <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?');" data-toggle="tooltip" title="Hapus Menu"><i class="fas fa-trash"></i></a>
        </td>
    </tr>
@endforeach
  </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

{{-- Menambahkan JS untuk DataTables --}}
@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#menu-table').DataTable({
                // Konfigurasi untuk mengaktifkan fitur dan menerjemahkan ke Bahasa Indonesia
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri per halaman",
                    zeroRecords: "Tidak ada data yang cocok",
                    info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    },
                },
                // Menonaktifkan sorting pada kolom yang tidak perlu (Gambar, Aksi)
                columnDefs: [{
                    "orderable": false,
                    "targets": [2, 6] 
                }]
            });

            // Inisialisasi Tooltip untuk ikon aksi
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

