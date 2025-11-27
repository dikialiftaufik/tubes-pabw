<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusReservasiController extends Controller
{
    public function index()
    {
        // Data dummy reservasi (nanti diganti database)
        $reservasiDummy = [
            [
                'nama' => 'Ega',
                'tanggal' => '2024-12-18',
                'jam' => '18:30',
                'jumlah_orang' => 4,
                'status' => 'Menunggu Konfirmasi'
            ],
            [
                'nama' => 'Budi',
                'tanggal' => '2024-12-18',
                'jam' => '19:00',
                'jumlah_orang' => 2,
                'status' => 'Dikonfirmasi'
            ],
            [
                'nama' => 'Rina',
                'tanggal' => '2024-12-19',
                'jam' => '17:00',
                'jumlah_orang' => 5,
                'status' => 'Selesai'
            ],
        ];

        return view('Kasir.status-reservasi', compact('reservasiDummy'));
    }
}
