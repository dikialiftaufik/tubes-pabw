@extends('layouts.user')

@section('content')
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-white mb-4 text-center">Konfirmasi Pembayaran</h2>

                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header border-secondary bg-transparent p-4">
                        <h5 class="text-white mb-0">Rincian Pesanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 rounded-3 mb-4">
                            <i class="fas fa-info-circle me-2"></i> Silakan periksa kembali pesanan Anda sebelum membayar.
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-dark table-borderless align-middle">
                                <thead>
                                    <tr class="border-bottom border-secondary">
                                        <th>Menu</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($pesanan))
                                        @foreach($pesanan->detailPesanan as $detail)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>{{ $detail->menu->nama ?? 'Menu Terhapus' }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $detail->jumlah }}</td>
                                                <td class="text-end">Rp {{ number_format($detail->menu->harga ?? 0, 0, ',', '.') }}</td>
                                                <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif(isset($cart))
                                         {{-- Handle jika data masih dari session cart (sebelum checkout) --}}
                                        @foreach($cart as $id => $details)
                                            <tr>
                                                <td>{{ $details['name'] }}</td>
                                                <td class="text-center">{{ $details['quantity'] }}</td>
                                                <td class="text-end">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                                <td class="text-end fw-bold">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Tidak ada data pesanan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="border-top border-secondary">
                                        <td colspan="3" class="text-end fw-bold fs-5">Total Pembayaran</td>
                                        <td class="text-end fw-bold fs-5 text-warning">
                                            {{-- PERBAIKAN: Gunakan total_hrg untuk object pesanan --}}
                                            @if(isset($pesanan))
                                                Rp {{ number_format($pesanan->total_hrg, 0, ',', '.') }}
                                            @elseif(isset($cart))
                                                @php $total = 0; foreach($cart as $c) $total += $c['price'] * $c['quantity']; @endphp
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{-- Form Pembayaran --}}
                        @if(isset($pesanan))
                        <form action="{{ route('pembayaran.proses', $pesanan->id_pesanan) }}" method="GET">
                            <div class="mb-4">
                                <label class="form-label text-white fw-bold">Pilih Metode Pembayaran</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="cash" value="cash" checked>
                                        <label class="btn btn-outline-light w-100 py-3" for="cash">
                                            <i class="fas fa-money-bill-wave fa-2x mb-2 d-block"></i>
                                            Tunai (Kasir)
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="qris" value="qris">
                                        <label class="btn btn-outline-light w-100 py-3" for="qris">
                                            <i class="fas fa-qrcode fa-2x mb-2 d-block"></i>
                                            QRIS
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="transfer" value="transfer">
                                        <label class="btn btn-outline-light w-100 py-3" for="transfer">
                                            <i class="fas fa-university fa-2x mb-2 d-block"></i>
                                            Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg py-3 fw-bold">
                                    <i class="fas fa-check-circle me-2"></i> Konfirmasi Pembayaran
                                </button>
                                <a href="{{ route('cart.view') }}" class="btn btn-outline-light py-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </form>
                        @else
                            {{-- Tombol Checkout jika masih di cart view --}}
                            <div class="d-grid gap-2">
                                <form action="{{ route('checkout.process') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg py-3 fw-bold w-100">
                                        <i class="fas fa-check-circle me-2"></i> Checkout
                                    </button>
                                </form>
                                <a href="{{ route('cart.view') }}" class="btn btn-outline-light py-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Keranjang
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection