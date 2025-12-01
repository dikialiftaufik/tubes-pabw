<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class StatusReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservation::latest()->get();
        return view('kasir.status-reservasi', compact('reservasi'));
    }

    public function updateStatus($id)
    {
        $reservasi = Reservation::findOrFail($id);

        // Logika otomatis
        if ($reservasi->status === 'pending') {
            $reservasi->status = 'confirmed';
        } elseif ($reservasi->status === 'confirmed') {
            $reservasi->status = 'done';
        } else {
            $reservasi->status = 'pending';
        }

        $reservasi->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function cancel($id)
    {
        $reservasi = Reservation::findOrFail($id);
        $reservasi->status = 'cancelled';
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan!');
    }
}
