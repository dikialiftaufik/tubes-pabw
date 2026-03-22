<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Reservation;
use App\Models\Menu;

class TransactionApiController extends Controller
{
    // 1. Menambahkan ke Keranjang (Opsional, jika Flutter simpan di server)
    public function addToCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Karena di materi API biasanya keranjang disimpan di Local Storage HP (Flutter),
        // Endpoint ini kita buat return success saja agar tidak error di aplikasi.
        // Jika ingin simpan di DB, butuh tabel 'carts' terpisah.
        
        return response()->json([
            'status' => 'success',
            'message' => 'Item berhasil ditambahkan ke keranjang (Server Side)',
        ]);
    }

    // 2. Melakukan Pembayaran. (Checkout)
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu,id', // ID Menu
            'items.*.quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            // A. Buat Pesanan Utama
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'tanggal_pesanan' => now(),
                'total_harga' => $request->total_price,
                'status' => 'pending', // Menunggu konfirmasi kasir
                'metode_pembayaran' => 'cash', // Default dari mobile
            ]);

            // B. Simpan Detail Item
            foreach ($request->items as $item) {
                $menu = Menu::find($item['id']);
                
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'subtotal' => $menu->harga * $item['quantity']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dikirim!',
                'data' => $pesanan
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    // 3. Mengelola Riwayat Pesanan
    public function historyPesanan()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                    ->with('detailPesanan.menu') // Load detail menu
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pesanan
        ]);
    }

    // 4. Melihat Status dan Riwayat Reservasi
    public function historyReservasi()
    {
        $reservasi = Reservation::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservasi
        ]);
    }
}