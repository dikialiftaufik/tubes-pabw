@extends('layouts.user')

@section('content')
<div class="container py-5" style="margin-top: 80px;"> <div class="mb-4">
        <a href="{{ route('menu.index') }}" class="btn btn-outline-dark rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Menu
        </a>
    </div>

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-lg-6 bg-light d-flex align-items-center justify-content-center position-relative">
                @if($menu->foto)
                    <img src="{{ asset('img/menu/' . $menu->foto) }}" 
                         class="img-fluid w-100 h-100" 
                         style="object-fit: cover; min-height: 400px; max-height: 550px;" 
                         alt="{{ $menu->nama }}">
                @else
                    <div class="text-muted p-5 text-center">
                        <i class="fas fa-utensils fa-4x mb-3"></i><br>
                        Gambar belum tersedia
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="card-body p-4 p-md-5 d-flex flex-column h-100">
                    
                    <h2 class="fw-bold text-dark mb-2">{{ $menu->nama }}</h2>
                    <h3 class="text-primary fw-bold mb-4">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </h3>

                    <p class="text-muted lead mb-4" style="font-size: 1rem; line-height: 1.6;">
                        {{ $menu->deskripsi }}
                    </p>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border border-light h-100">
                                <div class="bg-white p-2 rounded-circle shadow-sm text-success me-3 flex-shrink-0">
                                    <i class="fas fa-leaf fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Bahan Utama</small>
                                    <h6 class="mb-0 fw-semibold text-dark mt-1" style="line-height: 1.4;">
                                        {{ $menu->bahan }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border border-light h-100">
                                <div class="bg-white p-2 rounded-circle shadow-sm text-danger me-3 flex-shrink-0">
                                    <i class="fas fa-fire-alt fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Kalori</small>
                                    <h6 class="mb-0 fw-semibold text-dark mt-1">{{ $menu->kalori }} kkal</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <hr class="mb-4">
                        
                        <form action="#" method="POST">
                            @csrf
                            <div class="row align-items-end"> 
                                
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <label class="form-label small text-muted fw-bold d-block mb-2">Atur Jumlah</label>
                                    
                                    <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1 border" style="width: fit-content;">
                                        <button type="button" class="btn btn-white rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center text-primary" 
                                                style="width: 36px; height: 36px;" onclick="decrementValue()">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        
                                        <input type="number" name="quantity" id="quantity" 
                                               class="form-control border-0 bg-transparent text-center fw-bold mx-2" 
                                               value="1" min="1" max="{{ $menu->stok }}" 
                                               style="width: 50px; font-size: 1.1rem;">
                                        
                                        <button type="button" class="btn btn-primary rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center text-white" 
                                                style="width: 36px; height: 36px;" onclick="incrementValue()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted"><i class="fas fa-box-open me-1"></i>Stok: {{ $menu->stok }}</small>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div style="padding-bottom: 2px;"> 
                                        <button type="submit" class="btn btn-primary w-100 py-3 shadow fw-bold" 
                                                style="border-radius: 15px;" {{ $menu->stok < 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus me-2"></i> Tambahkan ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function incrementValue() {
        var quantityInput = document.getElementById('quantity');
        var value = parseInt(quantityInput.value, 10);
        var max = {{ $menu->stok }}; 
        
        value = isNaN(value) ? 0 : value;
        if(value < max){
            value++;
            quantityInput.value = value;
        }
    }

    function decrementValue() {
        var quantityInput = document.getElementById('quantity');
        var value = parseInt(quantityInput.value, 10);
        
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            quantityInput.value = value;
        }
    }
</script>
@endsection