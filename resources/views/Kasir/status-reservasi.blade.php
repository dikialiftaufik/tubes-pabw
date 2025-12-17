@extends('layouts.kasir')

@section('title', 'Kelola Status Reservasi')

@section('content')

    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">Kelola Status Reservasi</h2>
    </div>

    <div class="card bg-dark text-white shadow-sm mb-5 border-secondary">

        <div class="card-header border-bottom border-secondary">
            <h4 class="mb-0">Daftar Reservasi</h4>
        </div>

        <div class="card-body">

            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Jumlah Orang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($reservasi as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->nama_pemesan }}</td>
                            <td>{{ $r->tgl_reservasi }}</td>
                            <td>{{ $r->jam_mulai }} - {{ $r->jam_selesai }}</td>
                            <td>{{ $r->jml_org }}</td>

                            <td class="fw-bold 
                                @if($r->status_reservasi == 'pending') text-warning
                                @elseif($r->status_reservasi == 'diterima') text-info
                                @elseif($r->status_reservasi == 'selesai') text-success
                                @elseif($r->status_reservasi == 'batal') text-secondary
                                @endif">
                                {{ ucfirst($r->status_reservasi) }}
                            </td>

                            <td>
                                {{-- CANCEL --}}
                                <form action="{{ route('kasir.reservasi.cancel', $r->id_reservasi) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Cancel</button>
                                </form>

                                {{-- UPDATE STATUS --}}
                                <form action="{{ route('kasir.reservasi.update', $r->id_reservasi) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">Ubah Status</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

@endsection