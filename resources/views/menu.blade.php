@extends('layouts.user')

@section('content')
    <style>
        /* Efek Hover pada Card Menu */
        .menu-card {
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            /* Border halus default */
        }

        .menu-card:hover {
            border-color: #0d6efd;
            /* Warna primary saat hover */
            transform: translateY(-5px);
            /* Sedikit naik agar interaktif */
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .img-menu {
            object-fit: cover;
            height: 250px;
            width: 100%;
        }
    </style>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold">Daftar Menu Kami</h1>
            <p class="text-muted">Nikmati hidangan terbaik yang disiapkan dengan bahan pilihan</p>
        </div>

        <div class="row g-4">
            @foreach($dt_menu as $menu)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden menu-card position-relative">

                        <div class="overflow-hidden">
                            @if($menu->foto)
                                <img class="img-menu" src="{{ asset('img/menu/' . $menu->foto) }}" alt="{{ $menu->nama }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light img-menu text-muted">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column p-4">



                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold text-dark mb-0">{{ $menu->nama }}</h5>
                                <span class="badge bg-{{ $menu->stok > 0 ? 'success' : 'danger' }} rounded-pill px-3">
                                    {{ $menu->stok > 0 ? 'Stok: ' . $menu->stok : 'Habis' }}
                                </span>
                            </div>

                            <p class="card-text text-muted small flex-grow-1 mb-4">
                                {{ Str::limit($menu->deskripsi, 60) }}
                            </p>

                            <hr class="text-muted opacity-25">

                            <div class="mb-3">
                                <span class="text-muted small">Harga</span>
                                <h5 class="text-primary fw-bold mb-0">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </h5>
                            </div>

                            <div class="d-grid gap-2 d-flex">
                                <a href="{{ route('menu.detail', $menu->id) }}"
                                    class="btn btn-outline-primary flex-grow-1 rounded-3">
                                    <i class="fas fa-info-circle me-1"></i> Detail
                                </a>

                                <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="d-flex flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 rounded-3" {{ $menu->stok < 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart me-1"></i> Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection