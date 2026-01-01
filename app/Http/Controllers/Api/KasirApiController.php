<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Reservation;

class KasirApiController extends Controller
{
    // === A. KELOLA STOK MENU ===
    
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $menu = Menu::find($id);
        if (!$menu) return response()->json(['message' => 'Menu not found'], 404);

        $menu->stok = $request->stok;
        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil diperbarui',
            'data' => $menu
        ]);
    }

    // === B. KELOLA STATUS PESANAN ===

    // Ambil daftar pesanan masuk (Pending/Confirmed)
    public function getIncomingOrders()
    {
        $orders = Pesanan::with(['user', 'detailPesanan.menu'])
                    ->whereIn('status', ['pending', 'confirmed', 'cooking'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    // Update status (pending -> confirmed -> done)
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        $pesanan = Pesanan::find($id);
        if (!$pesanan) return response()->json(['message' => 'Pesanan not found'], 404);

        $pesanan->status = $request->status;
        $pesanan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status pesanan diperbarui',
            'data' => $pesanan
        ]);
    }

    // === C. KELOLA STATUS RESERVASI ===

    public function getIncomingReservations()
    {
        $reservations = Reservation::with('user')
                        ->where('status', '!=', 'done') // Tampilkan yg belum selesai
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservations
        ]);
    }

    public function updateReservationStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        $reservasi = Reservation::find($id);
        if (!$reservasi) return response()->json(['message' => 'Reservasi not found'], 404);

        $reservasi->status = $request->status;
        $reservasi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status reservasi diperbarui',
            'data' => $reservasi
        ]);
    }
}