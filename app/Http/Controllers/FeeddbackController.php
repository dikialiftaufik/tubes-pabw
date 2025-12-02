<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeddbackController extends Controller
{
    public function index()
    {
        return view('feedback');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        // Insert ke tabel feeddback (double d)
        DB::table('feeddback')->insert([
            'nama' => $request->nama,
            'judul' => $request->judul,
            'pesan' => $request->pesan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('feedback.index')->with('success', 'Masukan berhasil dikirim!');
    }
}
