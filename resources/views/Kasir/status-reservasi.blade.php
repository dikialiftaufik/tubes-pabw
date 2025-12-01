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
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->date }}</td>
                    <td>{{ $r->time }}</td>
                    <td>{{ $r->people }}</td>

                    <td class="fw-bold 
                        @if($r->status == 'pending') text-warning
                        @elseif($r->status == 'confirmed') text-info
                        @elseif($r->status == 'done') text-success
                        @elseif($r->status == 'cancelled') text-secondary
                        @endif">
                        {{ ucfirst($r->status) }}
                    </td>

                    <td>
                        {{-- CANCEL --}}
                        <form action="{{ route('kasir.reservasi.cancel', $r->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-danger">Cancel</button>
                        </form>

                        {{-- UPDATE STATUS --}}
                        <form action="{{ route('kasir.reservasi.update', $r->id) }}" method="POST" class="d-inline">
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
