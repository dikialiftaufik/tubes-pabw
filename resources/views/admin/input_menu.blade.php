@extends('adminlte::page')

@section('title', 'Tambah Menu')

@section('content_header')
    <h1>Tambah Menu Baru</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            
            <form action="{{ route('admin.menu.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Menu</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama menu" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="foto">Foto Menu</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input" id="foto" required>
                                <label class="custom-file-label" for="foto">Pilih file gambar</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" id="harga" placeholder="Contoh: 25000" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" name="stok" class="form-control" id="stok" placeholder="Contoh: 10" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bahan">Bahan Utama</label>
                        <input type="text" name="bahan" class="form-control" id="bahan" placeholder="Contoh: Ayam, Kecap, Bawang" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kalori">Kalori (kkal)</label>
                                <input type="number" name="kalori" class="form-control" id="kalori" placeholder="Contoh: 350" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" class="form-control">
                                    <option value="main course">Main Course</option>
                                    <option value="beverage">Beverage</option>
                                    <option value="snack">Snack</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat menu..." required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@stop