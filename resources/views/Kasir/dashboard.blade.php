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
        <div class="card-body d-flex align-items-center">

            {{-- Foto Kasir --}}
            <img src="{{ asset('uploads/kasir/' . $foto) }}"
                 class="rounded-circle me-3"
                 alt="Foto Kasir"
                 style="width: 80px; height: 80px; object-fit: cover;">

            <div class="flex-grow-1">
                <h5 class="fw-bold mb-1">Kasir 1</h5>
                <p class="text-secondary mb-0">Role: Kasir</p>
            </div>

            {{-- Form Upload Foto --}}
            <form action="{{ route('kasir.upload-foto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="foto" class="form-control form-control-sm mb-2" required>
                <button type="submit" class="btn btn-sm btn-success">
                    Upload Foto
                </button>
            </form>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                <h4 class="fw-bold">Stok Menu</h4>
                <p class="fs-5 text-info">6 menu</p>
                <a href="{{ route('kasir.stok') }}" class="btn btn-outline-light">Kelola</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                <h4 class="fw-bold">Status Pesanan</h4>
                <p class="fs-5 text-warning">3 pesanan masuk</p>
                <a href="{{ route('kasir.status-pesanan') }}" class="btn btn-outline-light">Lihat</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark text-white text-center p-3 shadow-sm border-secondary">
                <h4 class="fw-bold">Status Reservasi</h4>
                <p class="fs-5 text-success">2 reservasi</p>
                <a href="{{ route('kasir.status-reservasi') }}" class="btn btn-outline-light">Lihat</a>
            </div>
        </div>

    </div>
</div>
@endsection
