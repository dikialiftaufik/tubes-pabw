<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /* =========================================================
     | USER - SIMPAN RESERVASI
     ========================================================= */
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

        // Notifikasi untuk user
        Notifikasi::create([
            'id_user'          => Auth::id(),
            'judul_notifikasi' => 'Reservasi Baru',
            'pesan_notifikasi' => 'Reservasi Anda untuk tanggal '
                . $request->tgl_reservasi . ' jam '
                . $request->jam_mulai . ' sedang menunggu konfirmasi (Pending)',
        ]);

        return redirect('/')->with('success', 'Reservasi berhasil dikirim');
    }

    /* =========================================================
     | ADMIN - LIST DATA
     ========================================================= */
    public function index()
    {
        $reservations = Reservation::orderBy('tgl_reservasi', 'desc')->get();
        return view('admin.reservations', compact('reservations'));
    }

    /* =========================================================
     | ADMIN - DETAIL (MODAL VIEW & EDIT)
     ========================================================= */
    public function show($id)
    {
        $reservation = Reservation::where('id_reservasi', $id)->firstOrFail();

        return response()->json([
            'id'     => $reservation->id_reservasi,
            'name'   => $reservation->nama_pemesan,
            'date'   => $reservation->tgl_reservasi,
            'time'   => $reservation->jam_mulai,
            'people' => $reservation->jml_org,
            'status' => ucfirst($reservation->status_reservasi),
        ]);
    }

    /* =========================================================
     | ADMIN - UPDATE DATA (AJAX)
     ========================================================= */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id_reservasi', $id)->firstOrFail();
        $oldStatus   = $reservation->status_reservasi;

        // Validasi input dari modal admin
        $request->validate([
            'name'   => 'required|string|max:255',
            'date'   => 'required|date',
            'time'   => 'required',
            'people' => 'required|integer|min:1',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        // Update data (mapping dari form admin → database)
        $reservation->update([
            'nama_pemesan'     => $request->name,
            'tgl_reservasi'    => $request->date,
            'jam_mulai'        => $request->time,
            'jml_org'          => $request->people,
            'status_reservasi' => strtolower($request->status),
        ]);

        /* ===== NOTIFIKASI JIKA STATUS BERUBAH ===== */
        $newStatus = strtolower($request->status);

        if ($oldStatus !== $newStatus && $reservation->id_user) {

            $statusMessage = match ($newStatus) {
                'confirmed' => 'Reservasi Anda telah DIKONFIRMASI ✅',
                'cancelled' => 'Reservasi Anda telah DIBATALKAN ❌',
                default     => 'Status reservasi Anda diperbarui',
            };

            Notifikasi::create([
                'id_user'          => $reservation->id_user,
                'judul_notifikasi' => 'Update Status Reservasi',
                'pesan_notifikasi' => $statusMessage
                    . ' untuk tanggal '
                    . $reservation->tgl_reservasi
                    . ' jam '
                    . $reservation->jam_mulai,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil diperbarui'
        ]);
    }

    /* =========================================================
     | ADMIN - DELETE
     ========================================================= */
    public function destroy($id)
    {
        $reservation = Reservation::where('id_reservasi', $id)->firstOrFail();
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil dihapus'
        ]);
    }
}
