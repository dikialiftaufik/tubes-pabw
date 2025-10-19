@extends('adminlte::page')

@section('title', 'Manajemen Reservasi Tempat')

@section('content_header')
    <h1>Manajemen Reservasi Tempat</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Reservasi Baru
            </a>
        </div>
        <div class="card-body">
            <table id="reservationsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Jumlah Orang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $index => $reservation)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reservation['customer_name'] }}</td>
                            <td>{{ $reservation['date'] }}</td>
                            <td>{{ $reservation['time'] }}</td>
                            <td>{{ $reservation['people'] }}</td>
                            <td>
                                @if ($reservation['status'] == 'Confirmed')
                                    <span class="badge bg-success">Confirmed</span>
                                @elseif ($reservation['status'] == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{ $reservation['status'] }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(function () {
            $('#reservationsTable').DataTable();
        });
    </script>
@stop
