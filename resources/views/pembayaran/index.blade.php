@extends('layouts.user')

@section('content')
    <div class="container py-5" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-white mb-4 text-center">Konfirmasi Pembayaran</h2>

                <div class="card bg-dark border-secondary shadow-lg">
                    <div class="card-header border-secondary bg-transparent p-4">
                        <h5 class="text-white mb-0">Rincian Pesanan #{{ $pesanan->id }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 rounded-3 mb-4">
                            <i class="fas fa-info-circle me-2"></i> Silakan selesaikan pembayaran Anda.
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-dark table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan->detailPesanan as $detail)
                                        <tr>
                                            <td>{{ $detail->menu->nama ?? 'Menu Terhapus' }}</td>
                                            <td class="text-center">{{ $detail->jumlah }}</td>
                                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top border-secondary">
                                    <tr>
                                        <td colspan="2" class="fw-bold text-end py-3">Total Tagihan</td>
                                        <td class="fw-bold text-end text-warning py-3">Rp
                                            {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <form action="{{ route('pembayaran.proses', $pesanan->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label text-white fw-bold">Pilih Metode Pembayaran</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="cash"
                                            value="cash" checked>
                                        <label class="btn btn-outline-light w-100 py-3" for="cash">
                                            <i class="fas fa-money-bill-wave fa-2x mb-2 d-block"></i>
                                            Tunai (Kasir)
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="qris"
                                            value="qris">
                                        <label class="btn btn-outline-light w-100 py-3" for="qris">
                                            <i class="fas fa-qrcode fa-2x mb-2 d-block"></i>
                                            QRIS
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="metode_pembayaran" id="transfer"
                                            value="transfer">
                                        <label class="btn btn-outline-light w-100 py-3" for="transfer">
                                            <i class="fas fa-university fa-2x mb-2 d-block"></i>
                                            Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">
                                    <i class="fas fa-check-circle me-2"></i> Bayar Sekarang
                                </button>
                                <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary">Batal / Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection