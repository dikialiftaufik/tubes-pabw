@extends('layouts.user')

@section('title', 'Beri Masukan')

@push('styles')
<style>
    .form-control {
        background-color: #a28f8fff;
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
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center mb-5">
            <h1 class="display-4">Beri Kami Masukan</h1>
            <p class="lead text-white-50">
                Saran dan kritik Anda sangat berharga
            </p>
        </div>

        <div class="card border-secondary">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label>Judul Masukan</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label>Pesan</label>
                        <textarea name="pesan" rows="6" class="form-control" required></textarea>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-submit">Kirim Masukan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
