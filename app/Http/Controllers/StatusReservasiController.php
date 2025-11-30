<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class StatusReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::latest()->get();
        return view('kasir.status-reservasi', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status = $request->status;
        $reservasi->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function cancel($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status = "Cancelled";
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan!');
    }
}
