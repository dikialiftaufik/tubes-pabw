@extends('layouts.kasir')

@section('title', 'Kelola Stok Menu')

@section('content')

<div class="text-center mb-4">
    <h2 class="fw-bold text-white">Kelola Stok Menu</h2>
    <p class="text-secondary">Update stok menu sesuai ketersediaan di dapur.</p>
</div>

@if (session('success'))
    <div class="alert alert-success text-center fw-bold">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4 mb-5">

    @foreach ($menus as $menu)
    <div class="col-md-4">
        <div class="card bg-dark text-white shadow-sm h-100 border-secondary">
            
            {{-- gambar menu --}}
            <img src="{{ asset('img/menu/' . $menu->foto) }}" 
                 class="card-img-top rounded-top" 
                 style="height: 200px; object-fit: cover;">
            
            <div class="card-body text-center">
                <h5 class="fw-bold text-white">{{ $menu->nama }}</h5>
                <p class="text-secondary">Rp {{ number_format($menu->harga,0,',','.') }}</p>

                {{-- Form Update Stok --}}
                <form action="{{ route('kasir.update-stok', $menu->id) }}" 
                      method="POST" 
                      class="d-flex justify-content-center mt-3">

                    @csrf

                    <input type="number" 
                           class="form-control w-50 text-center fw-bold" 
                           name="stok" 
                           value="{{ $menu->stok }}" 
                           min="0" required>

                    <button class="btn btn-success ms-2">Update</button>

                </form>

            </div>
        </div>
    </div>
    @endforeach

</div>

@endsection
