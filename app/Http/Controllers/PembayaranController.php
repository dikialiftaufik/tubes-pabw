<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\DetailPesanan;

class PembayaranController extends Controller
{
    // Halaman Pembayaran (Lihat Detail Pesanan & Tombol Konfirmasi)
    public function index($id = null)
    {
        if ($id) {
            $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);
            return view('pembayaran.index', compact('pesanan'));
        } else {
            $cart = session('cart');
            return view('pembayaran.index', compact('cart'));
        }
    }

    // PROSES CHECKOUT (Simpan Data & Redirect ke Menu)
    public function checkout()
    {
        // 1. Ambil data keranjang
        $cart = session()->get('cart');

        // Jika keranjang kosong, tendang balik
        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong!');
        }

        // 2. Hitung Total Harga
        $totalHarga = 0;
        foreach ($cart as $id => $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        // 3. Simpan ke Database (Gunakan Transaction biar aman)
        $pesanan = DB::transaction(function () use ($cart, $totalHarga) {

            // A. Simpan data utama PESANAN (Sesuaikan nama kolom dengan DB baru)
            $pesanan = Pesanan::create([
                'id_user' => Auth::id(),        // UBAH: user_id -> id_user
                'tanggal' => now(),
                'total_hrg' => $totalHarga,     // UBAH: total_harga -> total_hrg
                'status_pesanan' => 'diproses', // UBAH: status -> status_pesanan
                'metode_pembayaran' => 'cash',  // Default cash (opsional, nanti diupdate saat bayar)
                'status_pembayaran' => 'pending'
            ]);

            // B. Simpan Rincian Menu (DetailPesanan)
            foreach ($cart as $id => $details) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan, // UBAH: pesanan_id -> id_pesanan
                    'id_menu' => $id,                     // UBAH: menu_id -> id_menu
                    'jumlah' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity']
                ]);
            }

            return $pesanan;
        });

        // 4. Hapus Keranjang (Karena sudah dibeli)
        session()->forget('cart');

        // 5. Redirect ke Halaman Pembayaran (gunakan id_pesanan)
        return redirect()->route('pembayaran.detail', $pesanan->id_pesanan);
    }

    // Method untuk confirm pembayaran & redirect LANGSUNG ke menu
    public function proses(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Update metode pembayaran jika ada input dari form
        if ($request->has('metode_pembayaran')) {
            $pesanan->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => 'lunas' // Anggap lunas jika user klik konfirmasi (demo)
            ]);
        }

        // SOLUSI SESSION LOSS: Render view langsung TANPA redirect
        // Redirect menyebabkan session hilang dengan file driver
        $dt_menu = \App\Models\Menu::all();

        // Session flash untuk success message
        session()->flash('success', 'Pembayaran berhasil! Pesanan sedang diproses.');

        return view('menu', compact('dt_menu'));
    }

    // Halaman Sukses
    public function berhasil()
    {
        return redirect()->route('menu.index')->with('success', 'Pembayaran berhasil! Terima kasih atas pesanan Anda.');
    }
}