@extends('layouts.pembayaran')

@section('title', 'Pembayaran')

@section('content')
<div class="container py-4">

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-white">Halaman Pembayaran</h2>
        <p class="text-light">Selesaikan proses pembayaran pelanggan di sini.</p>
    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="card bg-dark text-white mb-4 shadow">
        <div class="card-header border-bottom border-secondary">
            <h5 class="mb-0 fw-bold">Detail Pembayaran</h5>
        </div>
        <div class="card-body">
            <p class="mb-1"><strong>Nama Pelanggan:</strong> Andi</p>
            <p class="mb-1"><strong>Nomor Pesanan:</strong> #P001</p>
            <p class="mb-3"><strong>Total Pembayaran:</strong> Rp 45.000</p>

            <div class="mb-3">
                <label for="metode" class="form-label text-light">Metode Pembayaran:</label>
                <select id="metode" class="form-select bg-secondary text-white border-0">
                    <option>Cash</option>
                    <option>QRIS</option>
                    <option>Transfer Bank</option>
                </select>
            </div>

            <div class="text-center">
                <button class="btn btn-success px-5 py-2 fw-bold shadow">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
