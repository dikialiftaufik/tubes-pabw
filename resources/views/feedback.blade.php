{{-- Mengambil kerangka dari layout utama untuk user --}}
@extends('layouts.user')

{{-- Mengisi judul halaman yang akan tampil di tab browser --}}
@section('title', 'Beri Masukan')

{{-- Menambahkan style CSS khusus untuk halaman ini --}}
@push('styles')
<style>
    /* Style spesifik hanya untuk elemen form di halaman feedback */
    .form-control {
        background-color: #2c2c2c;
        border-color: #444;
        color: #fff;
    }
    .form-control:focus {
        background-color: #333;
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        color: #fff;
    }
    .form-control::placeholder {
        color: #aaa;
    }
    .btn-submit {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #1a1a1a;
        font-weight: bold;
        padding: 10px 30px;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        color: #1a1a1a;
        transform: translateY(-2px);
    }
</style>
@endpush

{{-- Mengisi bagian konten utama halaman --}}
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-5">
            <h1 class="display-4" style="font-family: 'Lora', serif;">Beri Kami Masukan</h1>
            <p class="lead text-white-50">Saran dan kritik Anda sangat berharga untuk meningkatkan kualitas layanan kami.</p>
        </div>

        <div class="card bg-dark border-secondary">
            <div class="card-body p-4 p-md-5">
                <form action="#" method="POST">
                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" placeholder="Masukkan nama Anda" required>
                    </div>

                    {{-- Judul Masukan --}}
                    <div class="mb-4">
                        <label for="judul" class="form-label">Judul Masukan</label>
                        <input type="text" class="form-control" id="judul" placeholder="Contoh: Saran untuk menu baru" required>
                    </div>

                    {{-- Pesan Masukan --}}
                    <div class="mb-4">
                        <label for="pesan" class="form-label">Pesan Anda</label>
                        <textarea class="form-control" id="pesan" rows="6" placeholder="Tuliskan pesan, saran, atau kritik Anda di sini..." required></textarea>
                    </div>

                    {{-- Tombol Kirim --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-submit">Kirim Masukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Menambahkan script JavaScript khusus untuk halaman ini --}}
@push('scripts')
<script>
    // Di halaman ini, kita ingin navbar selalu memiliki background solid
    const navbar = document.getElementById('mainNavbar');
    navbar.classList.add('navbar-scrolled');
</script>
@endpush

