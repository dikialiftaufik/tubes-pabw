<?php

namespace App\Http\Controllers;


use App\Models\Reservation; 
use Illuminate\Http\Request;

class StatusReservasiController extends Controller
{
    public function index()
    {
        // Ganti Reservasi jadi Reservation
        $reservasi = Reservation::latest()->get(); 
        return view('kasir.status-reservasi', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Ganti Reservasi jadi Reservation
        $reservasi = Reservation::findOrFail($id); 
        $reservasi->status = $request->status;
        $reservasi->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function cancel($id)
    {
        // Ganti Reservasi jadi Reservation
        $reservasi = Reservation::findOrFail($id);
        $reservasi->status = "Cancelled";
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan!');
    }
}