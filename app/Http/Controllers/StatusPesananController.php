<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusPesananController extends Controller
{
    public function index()
    {
        // Data dummy, nanti bisa diganti database
        $pesananDummy = [
            ['nama' => 'Rina', 'menu' => 'Sate Ayam', 'jumlah' => 2, 'status' => 'Sedang Dibuat'],
            ['nama' => 'Budi', 'menu' => 'Tongseng Sapi', 'jumlah' => 1, 'status' => 'Selesai'],
            ['nama' => 'Dewi', 'menu' => 'Sate Kambing', 'jumlah' => 3, 'status' => 'Sedang Dibuat'],
        ];

        return view('Kasir.status-pesanan', compact('pesananDummy'));
    }
}
