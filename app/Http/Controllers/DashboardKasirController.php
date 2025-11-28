<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKasirController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard');
    }

    public function profil()
    {
        return view('kasir.profil');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('foto');
        $namaFile = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/kasir'), $namaFile);

        file_put_contents(public_path('uploads/kasir/foto.txt'), $namaFile);

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil diunggah!');
    }

    public function hapusFoto()
    {
        $path = public_path('uploads/kasir/foto.txt');

        if (file_exists($path)) {
            $namaFile = file_get_contents($path);
            $fotoPath = public_path('uploads/kasir/' . $namaFile);

            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }

            unlink($path);
        }

        return redirect()->route('kasir.profil')->with('success', 'Foto profil berhasil dihapus!');
    }
}
