@extends('layouts.user')

@section('content')
    <div class="container py-5" style="margin-top: 80px;">
        <h2 class="fw-bold text-white mb-4">Keranjang Belanja</h2>

        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr class="text-uppercase border-secondary">
                                <th scope="col" class="py-3">Menu</th>
                                <th scope="col" class="py-3">Jumlah</th>
                                <th scope="col" class="py-3">Harga</th>
                                <th scope="col" class="py-3">Total</th>
                                <th scope="col" class="py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-secondary">
                            @php $total = 0; @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                @if(isset($details['image']) && $details['image'])
                                                    <img src="{{ asset('img/menu/' . $details['image']) }}" alt="{{ $details['name'] }}"
                                                        class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <span class="fw-bold">{{ $details['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                {{-- Tombol Kurang --}}
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit" class="btn btn-outline-warning btn-sm" title="Kurangi">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                {{-- Quantity Display --}}
                                                <span class="badge bg-secondary fs-6 px-3 py-2">{{ $details['quantity'] }}</span>

                                                {{-- Tombol Tambah --}}
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Tambah">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="py-3">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                        <td class="py-3 fw-bold text-warning">Rp
                                            {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-3">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm rounded-circle" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-shopping-basket fa-3x mb-3"></i><br>
                                        Keranjang belanja Anda masih kosong.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent border-secondary p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-white mb-0">Total Bayar: <span class="text-warning fw-bold">Rp
                            {{ number_format($total, 0, ',', '.') }}</span></h4>

                    <div>
                        <a href="{{ route('menu.index') }}" class="btn btn-outline-light me-2">
                            <i class="fas fa-arrow-left me-1"></i> Lanjut Belanja
                        </a>
                        @if(session('cart') && count(session('cart')) > 0)
                            <form action="{{ route('checkout.process') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary fw-bold px-4">
                                    <i class="fas fa-wallet me-1"></i> Checkout
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection