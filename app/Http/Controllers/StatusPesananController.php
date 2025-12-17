<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class StatusPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.menu'])->orderBy('created_at', 'desc')->get();

        return view('kasir.status-pesanan', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Logika update status sederhana (Toggle)
        // pending -> sedang dibuat -> selesai -> pending (loop)
        // Atau sesuaikan dengan request input jika menggunakan dropdown

        if ($request->has('status')) {
            $pesanan->status_pesanan = $request->status;
        } else {
            // Default toggle logic jika tidak ada input spesifik
            switch ($pesanan->status_pesanan) {
                case 'pending':
                case 'diproses':
                    $pesanan->status_pesanan = 'disiapkan';
                    break;
                case 'disiapkan':
                    $pesanan->status_pesanan = 'selesai';
                    break;
                default:
                    $pesanan->status_pesanan = 'pending';
                    break;
            }
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
