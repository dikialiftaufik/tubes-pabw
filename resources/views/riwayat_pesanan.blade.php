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
                                <th class="py-3">Total Harga</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-secondary">
                            @forelse($pesanan as $p)
                                <tr>
                                    <td class="py-3">
                                        <i class="far fa-calendar-alt me-2 text-muted"></i>
                                        {{ $p->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-3 fw-bold text-warning">Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge {{ $p->status == 'pending' ? 'bg-warning text-dark' : ($p->status == 'Selesai' ? 'bg-success' : 'bg-secondary') }} rounded-pill px-3">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
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