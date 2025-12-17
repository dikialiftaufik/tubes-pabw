@extends('layouts.kasir')

@section('title', 'Dashboard Kasir')

@section('content')
    <div class="container">

        <h2 class="fw-bold mb-4 text-white">Dashboard Kasir</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profil Kasir --}}
        <div class="card bg-dark text-white shadow-sm mb-4 border-secondary">
            <div class="card-body d-flex align-items-center position-relative">

                {{-- Foto Kasir --}}
                <div class="position-relative">
                    <img src="{{ asset('uploads/kasir/' . $foto) }}" class="rounded-circle me-3" alt="Foto Kasir"
                        style="width: 90px; height: 90px; object-fit: cover;">

                    {{-- Tombol edit foto --}}
                    <a href="{{ route('kasir.profil') }}" class="btn btn-sm btn-warning position-absolute"
                        style="bottom: 0; right: 0; border-radius: 50%; padding: 6px;">
                        ✏️
                    </a>
                </div>

                <div class="flex-grow-1 ms-3">
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name ?? 'Kasir' }}</h5>
                    <p class="text-secondary mb-0">Role: {{ Auth::user()->role ?? 'Kasir' }}</p>
                </div>

                <div class="ms-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="row g-4">

            {{-- STOK MENU --}}
            <div class="col-md-4">
                <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                    <h4 class="fw-bold">Stok Menu</h4>
                    <p class="fs-5 text-info">{{ $stokMenu }} menu</p>
                    <a href="{{ route('kasir.stok') }}" class="btn btn-outline-light">Kelola</a>
                </div>
            </div>

            {{-- STATUS PESANAN --}}
            <div class="col-md-4">
                <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                    <h4 class="fw-bold">Status Pesanan</h4>
                    <p class="fs-5 text-warning">{{ $pesananMasuk }} pesanan masuk</p>
                    <a href="{{ route('kasir.status-pesanan') }}" class="btn btn-outline-light">Lihat</a>
                </div>
            </div>

            {{-- STATUS RESERVASI --}}
            <div class="col-md-4">
                <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                    <h4 class="fw-bold">Status Reservasi</h4>
                    <p class="fs-5 text-success">{{ $reservasiMasuk }} reservasi</p>
                    <a href="{{ route('kasir.status-reservasi') }}" class="btn btn-outline-light">Lihat</a>
                </div>
            </div>

        </div>
    </div>
@endsection