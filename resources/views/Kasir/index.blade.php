@extends('layouts.kasir')

@section('title', 'Kasir')

@section('content')
<div class="text-center mb-4">
    <h2 class="fw-bold text-white">Manajemen Kasir</h2>
    <p class="text-secondary">Atur stok, pantau status pesanan pelanggan, dan konfirmasi pembaruan stok di sini</p>
</div>

<div class="row g-4">
    @php
        $menus = [
            ['nama' => 'Sate Ayam', 'stok' => 10, 'gambar' => 'sate-ayam.jpg'],
            ['nama' => 'Sate Sapi', 'stok' => 5, 'gambar' => 'sate-sapi.jpg'],
            ['nama' => 'Sate Kambing', 'stok' => 0, 'gambar' => 'sate-kambing.jpg'],
            ['nama' => 'Tongseng Ayam', 'stok' => 8, 'gambar' => 'tongseng-ayam.jpg'],
            ['nama' => 'Tongseng Sapi', 'stok' => 2, 'gambar' => 'tongseng-sapi.jpg'],
            ['nama' => 'Tongseng Kambing', 'stok' => 0, 'gambar' => 'tongseng-kambing.jpg'],
        ];
    @endphp

    @foreach ($menus as $index => $menu)
    <div class="col-md-4">
        <div class="card text-center bg-dark text-white shadow-sm border-0 p-3">
            <img src="{{ asset('assets/' . $menu['gambar']) }}"
                class="card-img-top rounded mb-3"
                alt="{{ $menu['nama'] }}"
                style="height: 200px; object-fit: cover;">
            
            <h5 class="fw-bold">{{ $menu['nama'] }}</h5>
            <p>Stok: <span id="stok-{{ $index }}">{{ $menu['stok'] }}</span></p>
            
            <div class="d-flex justify-content-center gap-2 mb-2">
                <button class="btn btn-sm btn-danger" onclick="ubahStok({{ $index }}, -1)">−</button>
                <button class="btn btn-sm btn-success" onclick="ubahStok({{ $index }}, 1)">+</button>
            </div>

            <button class="btn btn-warning btn-sm mt-2" onclick="konfirmasiStok({{ $index }})">
                 Perbarui Stok
            </button>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-5">
    <div class="card bg-dark text-white">
        <div class="card-header fw-bold">Status Pemesanan</div>
        <div class="card-body">
            <table class="table table-dark table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Menu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center text-secondary">Belum ada data pesanan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="text-center text-secondary mt-3">
    © 2025 <span class="fw-bold text-light">BoloFood</span> — Kasir | Pemesanan Makanan Khas Jawa Tengah
</footer>

<script>
    function ubahStok(index, perubahan) {
        const stokElement = document.getElementById(`stok-${index}`);
        let stok = parseInt(stokElement.textContent);
        stok = Math.max(0, stok + perubahan); // mencegah stok negatif
        stokElement.textContent = stok;
    }

    function konfirmasiStok(index) {
        const stok = document.getElementById(`stok-${index}`).textContent;
        const namaMenu = document.querySelectorAll('.card h5')[index].textContent;
        alert(`✅ Stok untuk "${namaMenu}" telah diperbarui menjadi ${stok}.`);
        // nanti bisa diganti dengan:
        // fetch('/kasir/update-stok', { method: 'POST', body: JSON.stringify({ namaMenu, stok }) })
    }
</script>
@endsection
