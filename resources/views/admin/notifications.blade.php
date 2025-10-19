@extends('adminlte::page')

@section('title', 'Manajemen Notifikasi')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Notifikasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        {{-- Tombol Tambah dan Kontrol Lainnya --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Notifikasi Baru
                </a>
            </div>
        </div>

        {{-- Tabel Notifikasi --}}
        <div class="table-responsive">
            <table id="notifications-table" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 10%;">Gambar</th>
                        <th>Judul</th>
                        <th>Pesan</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $key => $notification)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ $notification['gambar'] }}" alt="Gambar Notifikasi" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td>{{ $notification['judul'] }}</td>
                            <td>{{ Str::limit($notification['pesan'], 100, '...') }}</td>
                            <td class="text-center">
                                @if($notification['status'] == 'Published')
                                    <span class="badge badge-success">{{ $notification['status'] }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $notification['status'] }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
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
        $('#notifications-table').DataTable({
            // Konfigurasi DOM untuk menata letak elemen
            // l = length changing, B = Buttons, f = filter (search), r = processing, t = table, i = info, p = pagination
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            // Kolom yang tidak bisa di-sort
            "columnDefs": [
                { "orderable": false, "targets": [1, 5] } // Kolom Gambar dan Aksi
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