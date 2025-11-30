<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKasirController extends Controller
{
    // helper: ambil nama file foto dari session, atau default.png jika belum ada
    protected function getFotoFromSession()
    {
        // gunakan 'default.png' sebagai fallback; buat file default.png di public/uploads/kasir/ (atau sesuaikan)
        return session('foto_kasir', 'default.png');
    }

    // tampilkan dashboard (kirim $foto ke view)
    public function index()
    {
        $foto = $this->getFotoFromSession();
        return view('kasir.dashboard', compact('foto'));
    }

    // halaman profil (form upload & hapus)
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

        //tempat menyimpan
        if (!is_dir(public_path('uploads/kasir'))) {
            mkdir(public_path('uploads/kasir'), 0755, true);
        }

        // hapus foto lama jika bukan default
        $old = session('foto_kasir', null);
        if ($old && $old !== 'default.png') {
            $oldPath = public_path('uploads/kasir/' . $old);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        // simpan file baru
        $file->move(public_path('uploads/kasir'), $namaFile);

        // simpan nama file di session (sementara sebelum DB)
        session(['foto_kasir' => $namaFile]);

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil diunggah!');
    }

    // hapus foto profil (kembalikan ke default)
    public function hapusFoto()
    {
        $old = session('foto_kasir', null);
        if ($old && $old !== 'default.png') {
            $oldPath = public_path('uploads/kasir/' . $old);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        // set kembali ke default
        session(['foto_kasir' => 'default.png']);

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil dihapus!');
    }
}
