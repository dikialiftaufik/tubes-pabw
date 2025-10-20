@extends('layouts.pembayaran')

@section('title', 'Pembayaran')

@section('content')
<div class="container py-4">
    {{-- Judul --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-white">Halaman Pembayaran</h2>
        <p class="text-secondary">Selesaikan proses pembayaran pelanggan di sini.</p>
    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="card bg-dark text-white shadow-sm">
        <div class="card-header border-bottom border-secondary">
            <h5 class="mb-0 fw-bold">Detail Pembayaran</h5>
        </div>
        <div class="card-body">
            <p><strong>Nama Pelanggan:</strong> Andi</p>
            <p><strong>Nomor Pesanan:</strong> #P001</p>
            <p><strong>Total Pembayaran:</strong> Rp 45.000</p>

            <div class="mb-3">
                <label for="metode" class="form-label text-light">Metode Pembayaran</label>
                <select id="metode" class="form-select bg-secondary text-white">
                    <option>Cash</option>
                    <option>QRIS</option>
                    <option>Transfer Bank</option>
                </select>
            </div>

            <a href="{{ route('pembayaran.berhasil') }}" class="btn btn-success w-100 mt-3">
                Konfirmasi Pembayaran
            </a>
        </div>
    </div>
</div>
@endsection
