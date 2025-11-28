@extends('adminlte::page')

@section('title', 'Edit Menu')

@section('content_header')
    <h1>Edit Data Menu</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Menu</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $menu->nama }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Saat Ini</label><br>
                        @if($menu->foto)
                            <img src="{{ asset('img/menu/' . $menu->foto) }}" alt="{{ $menu->nama }}" class="img-thumbnail mb-2" style="width: 150px">
                        @else
                            <span class="badge badge-secondary">Tidak ada foto</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="foto">Ganti Foto (Opsional)</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="foto" class="custom-file-input" id="foto">
                                <label class="custom-file-label" for="foto">Pilih file baru jika ingin mengganti</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" id="harga" value="{{ $menu->harga }}" required>
                    </div>

                    <div class="form-group">
                        <label for="bahan">Bahan Utama</label>
                        <input type="text" name="bahan" class="form-control" id="bahan" value="{{ $menu->bahan }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kalori">Kalori (kkal)</label>
                                <input type="number" name="kalori" class="form-control" id="kalori" value="{{ $menu->kalori }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" class="form-control">
                                    <option value="main course" {{ $menu->kategori == 'main course' ? 'selected' : '' }}>Main Course</option>
                                    <option value="beverage" {{ $menu->kategori == 'beverage' ? 'selected' : '' }}>Beverage</option>
                                    <option value="snack" {{ $menu->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required>{{ $menu->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt mr-1"></i> Update Data</button>
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