<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class ApiPaymentController extends Controller
{
    // 1. Cek Status Pesanan (GET)
    // URL: GET /api/cek-status/{id}
    public function checkStatus($id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->find($id);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $pesanan->id_pesanan,
                'id_user' => $pesanan->id_user, // Corrected from id_pembeli
                'tanggal' => $pesanan->tanggal,
                'total_harga' => $pesanan->total_hrg, // Corrected from total_harga
                'status_pesanan' => $pesanan->status_pesanan,
                'status_pembayaran' => $pesanan->status_pembayaran, // Added correct payment status
                'metode_pembayaran' => $pesanan->metode_pembayaran,
                'items' => $pesanan->detailPesanan->map(function ($detail) {
                    return [
                        'menu_nama' => $detail->menu->nama ?? 'Terhapus',
                        'jumlah' => $detail->jumlah,
                        'subtotal' => $detail->subtotal
                    ];
                }),
                'waktu_pesan' => $pesanan->created_at->format('Y-m-d H:i:s'),
                'waktu_update' => $pesanan->updated_at->format('Y-m-d H:i:s')
            ]
        ], 200);
    }

    // 2. Konfirmasi Pembayaran Otomatis (POST)
    // URL: POST /api/konfirmasi-bayar
    // Body: { "pesanan_id": 1, "metode_pembayaran": "qris" (optional) }
    public function confirmPayment(Request $request)
    {
        \Log::info('API Confirm Payment Hit', $request->all());

        // Validasi input
        $validated = $request->validate([
            'pesanan_id' => 'required|integer|exists:pesanan,id_pesanan',
            'metode_pembayaran' => 'nullable|in:cash,qris,transfer,tunai'
        ]);

        // Cari pesanan
        $pesanan = Pesanan::find($validated['pesanan_id']);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        // Cek apakah sudah lunas
        if ($pesanan->status_pembayaran === 'lunas') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan sudah dikonfirmasi sebelumnya',
                'current_status' => $pesanan->status_pembayaran
            ], 400);
        }

        // Update status pembayaran
        $pesanan->status_pembayaran = 'lunas'; // Corrected: update payment status

        // Update status pesanan jika statusnya masih pending
        if ($pesanan->status_pesanan == 'pending') {
            $pesanan->status_pesanan = 'diproses';
        }

        if (isset($validated['metode_pembayaran'])) {
            $pesanan->metode_pembayaran = $validated['metode_pembayaran'];
        }
        $pesanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi!',
            'data' => [
                'pesanan_id' => $pesanan->id_pesanan,
                'status_pembayaran' => $pesanan->status_pembayaran,
                'status_pesanan' => $pesanan->status_pesanan,
                'total_dibayar' => $pesanan->total_hrg, // Corrected total_harga
                'metode_pembayaran' => $pesanan->metode_pembayaran,
                'waktu_konfirmasi' => now()->format('Y-m-d H:i:s')
            ]
        ], 200);
    }
}