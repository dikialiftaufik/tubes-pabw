<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class ApiPaymentController extends Controller
{
    // 1. Cek Status Pesanan (GET)
   
    public function checkStatus($id)
    {
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $pesanan->id,
                'total_harga' => $pesanan->total_harga,
                'status_pembayaran' => $pesanan->status, // pending/lunas
                'waktu_pesan' => $pesanan->created_at
            ]
        ], 200);
    }

    // 2. Konfirmasi Pembayaran Otomatis (POST)
    // Simulasi: Menerima sinyal dari "Bank" untuk melunaskan pesanan
    public function confirmPayment(Request $request)
    {
        // Mencari pesanan berdasarkan ID yang dikirim
        $pesanan = Pesanan::find($request->pesanan_id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Ubah status di database jadi 'lunas'
        $pesanan->status = 'lunas'; // Pastikan sesuai enum di database Anda ('lunas'/'selesai')
        $pesanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi oleh sistem!',
            'data_terupdate' => $pesanan
        ], 200);
    }
}