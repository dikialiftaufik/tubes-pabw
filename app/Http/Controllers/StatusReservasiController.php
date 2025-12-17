<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class StatusReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservation::orderBy('created_at', 'desc')->get();
        return view('kasir.status-reservasi', compact('reservasi'));
    }

    public function updateStatus($id)
    {
        $reservasi = Reservation::findOrFail($id);

        // Status flow: pending -> diterima -> selesai
        if ($reservasi->status_reservasi === 'pending') {
            $reservasi->status_reservasi = 'diterima';
        } elseif ($reservasi->status_reservasi === 'diterima') {
            $reservasi->status_reservasi = 'selesai';
        } else {
            // Optional loop back or stay
            $reservasi->status_reservasi = 'pending';
        }

        $reservasi->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function cancel($id)
    {
        $reservasi = Reservation::findOrFail($id);
        $reservasi->status_reservasi = 'batal';
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan!');
    }
}
