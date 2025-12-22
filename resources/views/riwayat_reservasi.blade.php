@extends('layouts.user')

@section('content')
    <div class="container py-5" style="margin-top: 80px;">
        <h2 class="fw-bold text-white mb-4">Riwayat Reservasi Saya</h2>

        <div class="card bg-dark border-secondary shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase border-secondary">
                                <th class="py-3">Tanggal Reservasi</th>
                                <th class="py-3">Nama Pemesan</th>
                                <th class="py-3">Jumlah Orang</th>
                                <th class="py-3">Jam</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-secondary">
                            @forelse($reservasi as $r)
                                <tr>
                                    <td class="py-3">
                                        <i class="far fa-calendar-alt me-2 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($r->tgl_reservasi)->format('d M Y') }}
                                    </td>
                                    <td class="py-3">
                                        {{ $r->nama_pemesan }}
                                    </td>
                                    <td class="py-3">
                                        <i class="fas fa-users me-2 text-info"></i>
                                        {{ $r->jml_org }} Orang
                                    </td>
                                    <td class="py-3">
                                        <i class="far fa-clock me-2 text-warning"></i>
                                        {{ \Carbon\Carbon::parse($r->jam_mulai)->format('H:i') }} 
                                        @if($r->jam_selesai)
                                            - {{ \Carbon\Carbon::parse($r->jam_selesai)->format('H:i') }}
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $statusClass = 'bg-secondary';
                                            if($r->status_reservasi == 'pending') $statusClass = 'bg-warning text-dark';
                                            elseif($r->status_reservasi == 'diterima') $statusClass = 'bg-success';
                                            elseif($r->status_reservasi == 'selesai') $statusClass = 'bg-info';
                                            elseif($r->status_reservasi == 'batal') $statusClass = 'bg-danger';
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3">
                                            {{ ucfirst($r->status_reservasi) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3"></i><br>
                                        Belum ada riwayat reservasi.
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
