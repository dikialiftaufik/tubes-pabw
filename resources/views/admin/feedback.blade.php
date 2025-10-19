@extends('adminlte::page')

@section('title', 'Manajemen Feedback')

@section('content_header')
    <h1 class="m-0 text-dark">Manajemen Feedback</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="feedback-table" class="table table-bordered table-striped table-hover" style="width:100%">
                <thead class="thead-light text-center">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Nama User</th>
                        <th>Judul Masukan</th>
                        <th>Pesan Masukan</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbackData as $feedback)
                        <tr>
                            <td class="text-center">{{ $feedback['id'] }}</td>
                            <td>{{ $feedback['nama_user'] }}</td>
                            <td>{{ $feedback['judul'] }}</td>
                            <td>{{ Str::limit($feedback['pesan'], 120, '...') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($feedback['tanggal'])->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
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
        $('#feedback-table').DataTable({
            // Konfigurasi DOM untuk menata letak elemen
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            // Kolom yang tidak bisa di-sort
            "columnDefs": [
                { "orderable": false, "targets": [5] } // Kolom Aksi
            ],
            
            // Urutkan berdasarkan kolom Tanggal (indeks ke-4) secara descending (terbaru dulu)
            "order": [[ 4, "desc" ]],

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