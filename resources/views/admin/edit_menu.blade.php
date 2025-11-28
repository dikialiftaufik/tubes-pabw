@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Menu</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit Menu
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama" class="form-control" value="{{ $menu->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini</label><br>
                    @if($menu->foto)
                        <img src="{{ asset('img/menu/' . $menu->foto) }}" width="150" class="img-thumbnail mb-2">
                    @endif
                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
                    </div>
                    </div>

                <div class="mb-3">
                    <label class="form-label">Bahan Utama</label>
                    <input type="text" name="bahan" class="form-control" value="{{ $menu->bahan }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kalori (kkal)</label>
                    <input type="number" name="kalori" class="form-control" value="{{ $menu->kalori }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="main course" {{ $menu->kategori == 'main course' ? 'selected' : '' }}>Main Course</option>
                        <option value="beverage" {{ $menu->kategori == 'beverage' ? 'selected' : '' }}>Beverage</option>
                        <option value="snack" {{ $menu->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required>{{ $menu->deskripsi }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection