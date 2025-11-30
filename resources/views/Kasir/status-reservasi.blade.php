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
                @foreach ($reservasi as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->name }}</td>
                    <td>{{ $r->date }}</td>
                    <td>{{ $r->time }}</td>
                    <td>{{ $r->people }}</td>

                    {{-- PERBAIKAN: Kolom Status dijadikan satu logic saja --}}
                    <td class="status fw-bold 
                        @if(strtolower($r->status) == 'pending') text-warning
                        @elseif(strtolower($r->status) == 'confirmed') text-info
                        @elseif(strtolower($r->status) == 'done') text-success
                        @elseif(strtolower($r->status) == 'cancelled') text-secondary
                        @endif">
                        {{ $r->status }}
                    </td>

                    {{-- PERBAIKAN: Kolom Aksi dijadikan satu <td> berisi Cancel & Ubah Status --}}
                    <td>
                        {{-- Tombol Cancel (Form) --}}
                        <form action="{{ route('kasir.reservasi.cancel', $r->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-danger me-1"
                                onclick="return confirm('Yakin batalkan reservasi ini?')">
                                Cancel
                            </button>
                        </form>

                        {{-- Tombol Ubah Status (Satu saja) --}}
                        <button class="btn btn-sm btn-primary" onclick="ubahStatus(this)">
                            Ubah Status
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Script JS tetap sama
    function ubahStatus(button) {
        const statusElem = button.closest('tr').querySelector('.status');
        let current = statusElem.textContent.trim().toLowerCase(); // Pakai toLowerCase agar tidak sensitif huruf besar/kecil

        if (current === 'pending') {
            statusElem.textContent = 'Confirmed';
            statusElem.className = 'status fw-bold text-info';
        } 
        else if (current === 'confirmed') {
            statusElem.textContent = 'Done';
            statusElem.className = 'status fw-bold text-success';
        }
        else {
            statusElem.textContent = 'Pending';
            statusElem.className = 'status fw-bold text-warning';
        }
    }
</script>

@endsection