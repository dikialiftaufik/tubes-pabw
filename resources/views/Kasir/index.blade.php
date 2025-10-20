@extends('layouts.kasir')

@section('title', 'Kasir')

@section('content')
<div class="text-center mb-4">
    <h2 class="fw-bold text-white">Kasir - Pengelolaan Stok & Pesanan</h2>
    <p class="text-secondary">Atur stok makanan dan pantau status pesanan pelanggan di sini.</p>
</div>


<div id="alertBox" class="alert alert-success text-center fw-bold d-none" role="alert">
    Stok berhasil diperbarui ✅
</div>


<div class="row g-4 mb-5">
    @php
        $menus = [
            ['nama' => 'Sate Ayam', 'stok' => 10, 'gambar' => 'img/menu/sate-ayam.jpg'],
            ['nama' => 'Sate Sapi', 'stok' => 8, 'gambar' => 'img/menu/sate-sapi.jpg'],
            ['nama' => 'Sate Kambing', 'stok' => 5, 'gambar' => 'img/menu/sate-kambing.jpg'],
            ['nama' => 'Tongseng Ayam', 'stok' => 7, 'gambar' => 'img/menu/tongseng-ayam.jpg'],
            ['nama' => 'Tongseng Sapi', 'stok' => 6, 'gambar' => 'img/menu/tongseng-sapi.jpg'],
            ['nama' => 'Tongseng Kambing', 'stok' => 4, 'gambar' => 'img/menu/tongseng-kambing.jpg'],
        ];
    @endphp

    @foreach ($menus as $menu)
    <div class="col-md-4">
        <div class="card bg-dark text-white shadow-sm h-100 border-secondary">
            <img src="{{ asset($menu['gambar']) }}" class="card-img-top rounded-top" alt="{{ $menu['nama'] }}" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
                <h5 class="fw-bold text-white">{{ $menu['nama'] }}</h5>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <button class="btn btn-outline-light btn-sm me-2" onclick="ubahStok(this, -1)">−</button>
                    <span class="stok-angka fw-bold fs-5">{{ $menu['stok'] }}</span>
                    <button class="btn btn-outline-light btn-sm ms-2" onclick="ubahStok(this, 1)">+</button>
                </div>
                <button class="btn btn-success btn-sm mt-3" onclick="tampilkanNotif()">Perbarui Stok</button>
            </div>
        </div>
    </div>
    @endforeach
</div>


<div class="card bg-dark text-white shadow-sm mb-5 border-secondary">
    <div class="card-header border-bottom border-secondary">
        <h4 class="mb-0">Status Pesanan</h4>
    </div>
    <div class="card-body">
        @php
            $pesanan = [
                ['nama' => 'Rina', 'menu' => 'Sate Ayam', 'jumlah' => 2, 'status' => 'Sedang Dibuat'],
                ['nama' => 'Budi', 'menu' => 'Tongseng Sapi', 'jumlah' => 1, 'status' => 'Selesai'],
                ['nama' => 'Dewi', 'menu' => 'Sate Kambing', 'jumlah' => 3, 'status' => 'Sedang Dibuat'],
            ];
        @endphp

        <table class="table table-dark table-striped align-middle text-center">
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
            <tbody id="pesananTable">
                @foreach ($pesanan as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p['nama'] }}</td>
                    <td>{{ $p['menu'] }}</td>
                    <td>{{ $p['jumlah'] }}</td>
                    <td class="status {{ $p['status'] == 'Selesai' ? 'text-success' : 'text-warning' }}">
                        {{ $p['status'] }}
                    </td>
                    <td>
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
    // Fungsi ubah stok (dummy)
    function ubahStok(button, change) {
        const stokElem = button.parentElement.querySelector('.stok-angka');
        let currentStok = parseInt(stokElem.textContent);
        currentStok = Math.max(0, currentStok + change);
        stokElem.textContent = currentStok;
    }

    // Fungsi ubah status pesanan (dummy)
    function ubahStatus(button) {
        const statusElem = button.closest('tr').querySelector('.status');
        if (statusElem.textContent.trim() === 'Sedang Dibuat') {
            statusElem.textContent = 'Selesai';
            statusElem.classList.remove('text-warning');
            statusElem.classList.add('text-success');
        } else {
            statusElem.textContent = 'Sedang Dibuat';
            statusElem.classList.remove('text-success');
            statusElem.classList.add('text-warning');
        }
    }

    // Fungsi notifikasi stok berhasil diperbarui
    function tampilkanNotif() {
        const alertBox = document.getElementById('alertBox');
        alertBox.classList.remove('d-none');
        alertBox.classList.add('show');

        // otomatis hilang setelah 2 detik
        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 2000);
    }
</script>
@endsection
