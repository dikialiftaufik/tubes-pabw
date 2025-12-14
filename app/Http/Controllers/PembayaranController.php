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
        
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung Total
        $totalHarga = 0;
        foreach($cart as $id => $details) {
            $totalHarga += $details['price'] * $details['quantity'];
        }

        // Gunakan Transaction agar data aman
        DB::transaction(function () use ($cart, $totalHarga) {
            // 1. Buat Pesanan
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'tanggal_pesanan' => now(),
                'total_harga' => $totalHarga,
                'status' => 'pending', // Status awal, nanti diubah Kasir
                'metode_pembayaran' => 'cash', // Atau sesuai input user
            ]);

            // 2. Masukkan Detail Menu ke DetailPesanan
            foreach($cart as $id => $details) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $id,
                    'jumlah' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity']
                ]);
            }
        });

        // 3. Kosongkan Keranjang
        session()->forget('cart');

        return redirect()->route('riwayat.pesanan')->with('success', 'Pesanan berhasil dibuat! Silakan bayar di kasir.');
    }
}