@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Tambah Menu Baru</h2>
    <form action="{{ url('/admin/menu/simpan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label>Nama Menu</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Bahan Utama</label>
            <input type="text" name="bahan" class="form-control" placeholder="Contoh: Ayam, Kecap, Bawang" required>
        </div>

        <div class="mb-3">
            <label>Kalori (kkal)</label>
            <input type="number" name="kalori" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control">
                <option value="main course">Main Course</option>
                <option value="beverage">Beverage</option>
                <option value="snack">Snack</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection