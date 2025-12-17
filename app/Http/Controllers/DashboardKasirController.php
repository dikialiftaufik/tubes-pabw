<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Reservation;

class DashboardKasirController extends Controller
{
    // helper: ambil nama file foto dari session, atau default.png jika belum ada
    protected function getFotoFromSession()
    {
        return session('foto_kasir', 'default.png');
    }

    // DASHBOARD KASIR
    public function index()
    {
        $foto = $this->getFotoFromSession();

        // === DATA ASLI DARI DATABASE ===
        $stokMenu = Menu::count();
        $pesananMasuk = Pesanan::count();
        // PERBAIKAN: Tabel reservations sudah ada (reservasi)
        $reservasiMasuk = Reservation::count();

        return view('kasir.dashboard', compact(
            'foto',
            'stokMenu',
            'pesananMasuk',
            'reservasiMasuk'
        ));
    }

    // halaman profil kasir
    public function profil()
    {
        $foto = $this->getFotoFromSession();
        return view('kasir.profil-kasir', compact('foto'));
    }

    // proses upload foto
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('foto');
        $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // buat folder kalau belum ada
        if (!is_dir(public_path('uploads/kasir'))) {
            mkdir(public_path('uploads/kasir'), 0755, true);
        }

        // hapus foto lama jika bukan default
        $old = session('foto_kasir');
        if ($old && $old !== 'default.png') {
            $oldPath = public_path('uploads/kasir/' . $old);
            if (file_exists($oldPath))
                unlink($oldPath);
        }

        // simpan foto baru
        $file->move(public_path('uploads/kasir'), $namaFile);

        session(['foto_kasir' => $namaFile]);

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil diunggah!');
    }

    // hapus foto
    public function hapusFoto()
    {
        $old = session('foto_kasir', null);

        if ($old && $old !== 'default.png') {
            $oldPath = public_path('uploads/kasir/' . $old);
            if (file_exists($oldPath))
                unlink($oldPath);
        }

        session(['foto_kasir' => 'default.png']);

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil dihapus!');
    }
}
