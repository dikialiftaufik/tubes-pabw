@extends('layouts.kasir')

@section('title', 'Kelola Status Reservasi')

@section('content')

<div class="text-center mb-4">
    <h2 class="fw-bold text-white">Kelola Status Reservasi</h2>
    <p class="text-secondary">Pantau dan ubah status reservasi pelanggan di sini.</p>
</div>

<div class="card bg-dark text-white shadow-sm mb-5 border-secondary">
    <div class="card-header border-bottom border-secondary">
        <h4 class="mb-0">Daftar Reservasi</h4>
    </div>

    <div class="card-body">

        <table class="table table-dark table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Jumlah Orang</th>
                    <th>Status Reservasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservasiDummy as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r['nama'] }}</td>
                    <td>{{ $r['tanggal'] }}</td>
                    <td>{{ $r['jam'] }}</td>
                    <td>{{ $r['jumlah_orang'] }}</td>

                    <td class="status 
                        @if($r['status'] == 'Menunggu Konfirmasi') text-warning
                        @elseif($r['status'] == 'Dikonfirmasi') text-info
                        @else text-success
                        @endif">
                        {{ $r['status'] }}
                    </td>

                    <td>
                        <button class="btn btn-sm btn-primary me-1" onclick="ubahStatus(this)">Ubah Status</button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

<script>
    function ubahStatus(button) {
        const statusElem = button.closest('tr').querySelector('.status');
        let current = statusElem.textContent.trim();

        if (current === 'Menunggu Konfirmasi') {
            statusElem.textContent = 'Dikonfirmasi';
            statusElem.className = 'status text-info';
        } 
        else if (current === 'Dikonfirmasi') {
            statusElem.textContent = 'Selesai';
            statusElem.className = 'status text-success';
        }
        else {
            statusElem.textContent = 'Menunggu Konfirmasi';
            statusElem.className = 'status text-warning';
        }
    }
</script>

@endsection
