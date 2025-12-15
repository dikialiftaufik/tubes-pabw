<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung Total
        $totalHarga = 0;
        foreach ($cart as $id => $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        // Gunakan Transaction agar data aman
        $pesanan = DB::transaction(function () use ($cart, $totalHarga) {
            // 1. Buat Pesanan
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'tanggal' => now(),
                'total_harga' => $totalHarga,
                'status' => 'pending', // Status awal, nanti diubah Kasir
            ]);

            // 2. Masukkan Detail Menu ke DetailPesanan
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

        // 3. Kosongkan Keranjang
        session()->forget('cart');

        // Redirect ke Halaman Pembayaran, bukan langsung Riwayat
        return redirect()->route('pembayaran.index', $pesanan->id);
    }

    public function index($id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);

        // Pastikan hanya pemilik pesanan yang bisa akses
        if ($pesanan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pembayaran.index', compact('pesanan'));
    }

    public function proses(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);



        // Ubah status jika perlu, misalnya tetap pending atau menunggu konfirmasi
        // $pesanan->status = 'menunggu_konfirmasi'; 
        // $pesanan->save();

        // Redirect ke halaman Menu dengan pesan sukses
        return redirect()->route('menu.index')->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses.');
    }

    public function berhasil()
    {
        return view('pembayaran.berhasil');
    }
}