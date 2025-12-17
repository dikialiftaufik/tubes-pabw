@extends('layouts.user')

@section('content')
    <div class="container py-5" style="margin-top: 80px;">
        <h2 class="fw-bold text-white mb-4">Riwayat Pesanan Saya</h2>

        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase border-secondary">
                                <th class="py-3">Tanggal</th>
                                <th class="py-3">Menu Dipesan</th>
                                <th class="py-3">Total Harga</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-secondary">
                            @forelse($pesanan as $p)
                                <tr>
                                    <td class="py-3">
                                        <i class="far fa-calendar-alt me-2 text-muted"></i>
                                        {{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="py-3">
                                        @if($p->detailPesanan->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @php $totalQuantity = 0; @endphp
                                                @foreach($p->detailPesanan as $detail)
                                                    @php $totalQuantity += $detail->jumlah; @endphp
                                                    <li class="mb-1">
                                                        <i class="fas fa-utensils me-2 text-warning"></i>
                                                        <strong>{{ $detail->menu->nama ?? 'Menu Terhapus' }}</strong>
                                                        <span class="text-muted small">({{ $detail->jumlah }}x)</span>
                                                    </li>
                                                @endforeach
                                                <li class="mt-2 pt-2 border-top border-secondary">
                                                    <i class="fas fa-shopping-basket me-2 text-info"></i>
                                                    <strong class="text-warning">Total: {{ $totalQuantity }} item</strong>
                                                </li>
                                            </ul>
                                        @else
                                            <span class="text-muted">Tidak ada detail</span>
                                        @endif
                                    </td>
                                    <td class="py-3 fw-bold text-warning">
                                        {{-- PERBAIKAN: total_harga -> total_hrg --}}
                                        Rp {{ number_format($p->total_hrg, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3">
                                        {{-- PERBAIKAN: status -> status_pesanan --}}
                                        <span
                                            class="badge {{ $p->status_pesanan == 'pending' || $p->status_pesanan == 'diproses' ? 'bg-warning text-dark' : ($p->status_pesanan == 'Selesai' ? 'bg-success' : 'bg-secondary') }} rounded-pill px-3">
                                            {{ ucfirst($p->status_pesanan) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-history fa-3x mb-3"></i><br>
                                        Belum ada riwayat pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection