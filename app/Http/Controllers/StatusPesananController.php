<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class StatusPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detail.menu'])->get();

        return view('kasir.status-pesanan', compact('pesanan'));
    }
}
