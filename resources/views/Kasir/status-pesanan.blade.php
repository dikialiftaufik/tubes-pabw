@extends('layouts.kasir')

@section('title', 'Kelola Status Pesanan')

@section('content')

    <div class="text-center mb-4">
        <h2 class="fw-bold text-white">Kelola Status Pesanan</h2>
    </div>

    <div class="card bg-dark text-white shadow-sm mb-5 border-secondary">

        <div class="card-header border-bottom border-secondary">
            <h4 class="mb-0">Status Pesanan</h4>
        </div>

        <div class="card-body">

            <table class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $p->user->name ?? 'Tidak diketahui' }}</td>

                            <td>
                                @foreach($p->detailPesanan as $d)
                                    {{ $d->menu->nama ?? 'Menu' }} x{{ $d->jumlah }}<br>
                                @endforeach
                            </td>

                            <td>{{ $p->detailPesanan->sum('jumlah') }}</td>

                            <td class="status {{ $p->status_pesanan == 'Selesai' ? 'text-success' : 'text-warning' }}">
                                {{ $p->status_pesanan }}
                            </td>

                            <td>
                                <form action="{{ route('kasir.status.update', $p->id_pesanan) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="btn btn-sm {{ $p->status_pesanan == 'Selesai' ? 'btn-secondary' : 'btn-primary' }}">
                                        {{ $p->status_pesanan == 'Selesai' ? 'Buka Kembali' : 'Ubah Status' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>



@endsection