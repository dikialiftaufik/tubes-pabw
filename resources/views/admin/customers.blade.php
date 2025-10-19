@extends('adminlte::page')

@section('title', 'Data Pelanggan')

@section('content_header')
    <h1>Manajemen Data Pelanggan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah Pelanggan Baru
            </a>
        </div>
        <div class="card-body">
            <table id="customersTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $customer['name'] }}</td>
                            <td>{{ $customer['email'] }}</td>
                            <td>{{ $customer['phone'] }}</td>
                            <td>{{ $customer['joined'] }}</td>
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
            $('#customersTable').DataTable();
        });
    </script>
@stop
