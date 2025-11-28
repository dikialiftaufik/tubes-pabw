@extends('layouts.kasir')

@section('title', 'Profil Kasir')

@section('content')
<div class="container">

    <h2 class="fw-bold text-white mb-4">Pengaturan Profil Kasir</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Foto Profil --}}
    <div class="text-center mb-4">
        <img src="{{ asset('uploads/kasir/' . $foto) }}"
             class="rounded-circle shadow"
             style="width: 150px; height: 150px; object-fit: cover;">
    </div>

    {{-- Form Upload Foto --}}
    <div class="card bg-dark text-white border-secondary mb-3">
        <div class="card-body">

            <form action="{{ route('kasir.upload-foto') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Ganti Foto Profil</label>
                    <input type="file" name="foto" class="form-control bg-secondary text-white" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Upload Foto Baru</button>
            </form>

        </div>
    </div>

    {{-- Tombol Hapus Foto --}}
    <form action="{{ route('kasir.hapus-foto') }}" method="POST" class="mb-3">
        @csrf
        <button class="btn btn-danger w-100">Hapus Foto Profil</button>
    </form>

    {{-- Tombol Kembali --}}
    <a href="{{ route('kasir.dashboard') }}" class="btn btn-secondary w-100">Kembali</a>

</div>
@endsection
