<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PesananController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'id_user' => 'required',
            'total_hrg' => 'required',
            'metode_pembayaran' => 'required',
            'detail_pesanan' => 'required|array',
        ]);
        try {
            DB::beginTransaction();
            // 2. Simpan ke tabel Pesanan
            $pesanan = Pesanan::create([
                'id_user' => $request->id_user,
                'tanggal' => now(),
                'total_hrg' => $request->total_hrg,
                'status_pesanan' => 'diproses',
                'status_pembayaran' => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);
            // 3. Simpan Detail Pesanan
            foreach ($request->detail_pesanan as $item) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu' => $item['id_menu'],
                    'jumlah' => $item['jumlah'],
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'data' => $pesanan->load('details')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        // Mengambil semua riwayat pesanan (sesuaikan dengan id_user jika perlu)
        $pesanan = Pesanan::with('details.menu')->orderBy('created_at', 'desc')->get();
        return response()->json($pesanan);
    }
}