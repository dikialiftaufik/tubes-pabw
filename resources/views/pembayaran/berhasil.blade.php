@extends('layouts.pembayaran')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-dark">
    <div class="card text-center p-5 bg-success text-white shadow-lg" style="border-radius: 20px; max-width: 480px;">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill" style="font-size: 5rem;"></i>
        </div>
        <h2 class="fw-bold mb-3">Pembayaran Berhasil!</h2>
        <p class="mb-4">Terima kasih! Pesanan sedang diproses oleh dapur.</p>
        <a href="{{ url('/menu') }}" class="btn btn-light fw-bold w-50 mx-auto">Selesai</a>
    </div>
</div>

{{-- Tambahan Icon Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection
