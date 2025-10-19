<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        return view('reservasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah_orang' => 'required|integer|min:1',
        ]);
    }
}
