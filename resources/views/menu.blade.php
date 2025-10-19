{{-- Mengambil kerangka dari layout utama --}}
@extends('layouts.user')

{{-- Mengisi judul halaman --}}
@section('title', 'Menu Makanan')

{{-- Menambahkan style khusus untuk halaman ini --}}
@push('styles')
<style>
    /* Style yang spesifik untuk halaman menu */
    .hero-section {
        height: 60vh;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1974&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .card-menu {
        background-color: #2c2c2c;
        border: 1px solid #444;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    .card-menu:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.4);
    }
    .btn-order {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #1a1a1a;
        font-weight: bold;
    }
</style>
@endpush

{{-- Mengisi bagian konten utama --}}
@section('content')
<div class="hero-section text-white">
    <div>
        <h1 class="display-3" style="font-family: 'Lora', serif;">Sajian Khas Nusantara</h1>
        <p class="lead">Temukan cita rasa otentik yang diracik dari generasi ke generasi.</p>
    </div>
</div>

<div class="menu-list mt-5">
    <div class="row g-4">
        @foreach ($menuMakanan as $item)
            <div class="col-lg-4 col-md-6">
                <div class="card card-menu">
                    <img src="{{ $item['gambar'] }}" class="card-img-top" alt="{{ $item['nama'] }}" style="height: 200px; object-fit: cover;" onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Gambar';">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-white">{{ $item['nama'] }}</h5>
                        <p class="card-text text-white-50 flex-grow-1">{{ $item['deskripsi'] }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <p class="price mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            <a href="#" class="btn btn-order">Pesan</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

{{-- Menambahkan script khusus untuk halaman ini --}}
@push('scripts')
<script>
    const navbar = document.getElementById('mainNavbar');
    // Efek transparan hanya berlaku di halaman menu
    if (window.pageYOffset < 50) {
        navbar.style.backgroundColor = 'transparent';
    }
    window.onscroll = function () {
        if (window.pageYOffset > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
            navbar.style.backgroundColor = 'transparent';
        }
    };
</script>
@endpush
