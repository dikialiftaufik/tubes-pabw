<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jml_org'       => 'required|integer|min:1',
            'tgl_reservasi' => 'required|date',
            'jam_mulai'     => 'required',
        ]);

        $reservation = Reservation::create([
            'id_user'          => Auth::id(),
            'nama_pemesan'     => Auth::user()->name,
            'jml_org'          => $request->jml_org,
            'tgl_reservasi'    => $request->tgl_reservasi,
            'jam_mulai'        => $request->jam_mulai,
            'status_reservasi' => 'pending',
        ]);

        // Buat notifikasi untuk user
        Notifikasi::create([
            'id_user'           => Auth::id(),
            'judul_notifikasi'  => 'Reservasi Baru',
            'pesan_notifikasi'  => 'Reservasi Anda untuk tanggal ' . $request->tgl_reservasi . ' jam ' . $request->jam_mulai . ' sedang menunggu konfirmasi (Pending)',
        ]);

        return redirect('/')->with('success', 'Reservasi berhasil dikirim');
    }

    public function index()
    {
        $reservations = Reservation::orderBy('tgl_reservasi')->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function show($id)
    {
        return Reservation::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $oldStatus = $reservation->status_reservasi;
        
        $reservation->update([
            'nama_pemesan'    => $request->nama_pemesan,
            'jml_org'         => $request->jml_org,
            'tgl_reservasi'   => $request->tgl_reservasi,
            'jam_mulai'       => $request->jam_mulai,
            'status_reservasi'=> strtolower($request->status_reservasi)
        ]);

        // Jika status berubah, buat notifikasi baru untuk user
        $newStatus = strtolower($request->status_reservasi);
        if ($oldStatus !== $newStatus && $reservation->id_user) {
            $statusLabel = ucfirst($newStatus);
            $statusMessage = match($newStatus) {
                'confirmed' => 'Reservasi Anda telah DIKONFIRMASI',
                'cancelled' => 'Reservasi Anda telah DIBATALKAN',
                default => 'Status reservasi Anda: ' . $statusLabel
            };

            Notifikasi::create([
                'id_user'           => $reservation->id_user,
                'judul_notifikasi'  => 'Update Reservasi',
                'pesan_notifikasi'  => $statusMessage . ' untuk tanggal ' . $reservation->tgl_reservasi . ' jam ' . $reservation->jam_mulai,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}

