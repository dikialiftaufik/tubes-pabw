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

            // A. Simpan data utama PESANAN
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),        // Siapa yang beli
                'tanggal' => now(),             // Kapan
                'total_harga' => $totalHarga,   // Berapa totalnya
                'status' => 'pending',          // Status awal (menunggu konfirmasi kasir)
                'metode_pembayaran' => 'cash',  // Default cash
            ]);

            // B. Simpan Rincian Menu (DetailPesanan)
            foreach ($cart as $id => $details) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $id,
                    'jumlah' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity']
                ]);
            }

            return $pesanan;
        });

        // 4. Hapus Keranjang (Karena sudah dibeli)
        session()->forget('cart');

        // 5. Redirect ke Halaman Pembayaran (untuk pilih metode & konfirmasi)
        return redirect()->route('pembayaran.detail', $pesanan->id);
    }

    // Method untuk confirm pembayaran & redirect LANGSUNG ke menu
    public function proses($id)
    {
        // DEBUG: Log session state SEBELUM proses
        \Log::info('PAYMENT PROSES START', [
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
            'user_id' => Auth::id(),
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // DEBUG: Log session state SETELAH query
        \Log::info('PAYMENT PROSES AFTER QUERY', [
            'session_id' => session()->getId(),
            'auth_check' => Auth::check(),
            'user_id' => Auth::id(),
        ]);

        // SOLUSI RADIKAL: JANGAN redirect! Langsung render view menu
        // Redirect corrupt session dengan cookie driver, jadi kita render langsung
        $dt_menu = \App\Models\Menu::all();
        return view('menu', compact('dt_menu'));
    }

    // Halaman Sukses (Redirect ke menu setelah beberapa detik)
    public function berhasil()
    {
        // Bisa langsung redirect atau tampilkan view dulu
        return redirect()->route('menu.index')->with('success', 'Pembayaran berhasil! Terima kasih atas pesanan Anda.');
    }
}