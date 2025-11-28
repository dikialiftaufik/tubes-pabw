@extends('adminlte::page')

@section('title', 'Manajemen Menu')

@section('content_header')
    <h1>Manajemen Data Menu</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.menu.input') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Menu Baru
            </a>
        </div>
        <div class="card-body">
            <table id="menuTable" class="table table-bordered table-striped hover">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 15%">Nama Menu</th>
                        <th style="width: 20%">Foto</th>
                        <th style="width: 10%">Harga</th>
                        <th style="width: 40%">Deskripsi</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dt_menu as $index => $menu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $menu->nama }}</td>
                        <td>
                            @if($menu->foto)
                                <img src="{{ asset('img/menu/' . $menu->foto) }}" 
                                     alt="{{ $menu->nama }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 180px; height: auto;">
                            @else
                                <span class="badge badge-secondary">No Image</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        
                        <td>{{ Str::limit($menu->deskripsi, 255) }}</td>
                        
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-info btn-sm mr-1" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                <a href="{{ route('admin.menu.hapus', $menu->id) }}" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus menu {{ $menu->nama }}?')" 
                                   title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#menuTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [
                    { "orderable": false, "targets": [2, 5] } 
                ]
            });
        });
    </script>
@stop