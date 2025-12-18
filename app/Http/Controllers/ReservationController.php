<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /* =========================
       USER - SIMPAN RESERVASI
    ========================== */
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

        // Notifikasi user
        Notifikasi::create([
            'id_user'          => Auth::id(),
            'judul_notifikasi' => 'Reservasi Baru',
            'pesan_notifikasi' => 'Reservasi Anda untuk tanggal '
                . $request->tgl_reservasi . ' jam '
                . $request->jam_mulai . ' sedang menunggu konfirmasi',
        ]);

        return redirect('/')->with('success', 'Reservasi berhasil dikirim');
    }

    /* =========================
       ADMIN - LIST DATA
    ========================== */
    public function index()
    {
        $reservations = Reservation::orderBy('tgl_reservasi', 'desc')->get();
        return view('admin.reservations', compact('reservations'));
    }

    /* =========================
       ADMIN - SHOW (AJAX)
    ========================== */
    public function show($id)
    {
        $reservation = Reservation::where('id_reservasi', $id)->firstOrFail();

        return response()->json([
            'id_reservasi'     => $reservation->id_reservasi,
            'nama_pemesan'     => $reservation->nama_pemesan,
            'tgl_reservasi'    => $reservation->tgl_reservasi,
            'jam_mulai'        => $reservation->jam_mulai,
            'jml_org'          => $reservation->jml_org,
            'status_reservasi' => $reservation->status_reservasi,
        ]);
    }

    /* =========================
       ADMIN - UPDATE (AJAX)
    ========================== */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id_reservasi', $id)->firstOrFail();
        $oldStatus   = $reservation->status_reservasi;

        $request->validate([
            'nama_pemesan'     => 'required|string|max:100',
            'tgl_reservasi'    => 'required|date',
            'jam_mulai'        => 'required',
            'jml_org'          => 'required|integer|min:1',
            'status_reservasi' => 'required|in:pending,diterima,selesai,batal',
        ]);

        $reservation->update([
            'nama_pemesan'     => $request->nama_pemesan,
            'tgl_reservasi'    => $request->tgl_reservasi,
            'jam_mulai'        => $request->jam_mulai,
            'jml_org'          => $request->jml_org,
            'status_reservasi' => $request->status_reservasi,
        ]);

        /* ===== NOTIFIKASI JIKA STATUS BERUBAH ===== */
        if ($oldStatus !== $request->status_reservasi && $reservation->id_user) {

            $statusMessage = match ($request->status_reservasi) {
                'diterima' => 'Reservasi Anda TELAH DITERIMA ✅',
                'selesai'  => 'Reservasi Anda TELAH SELESAI 🎉',
                'batal'    => 'Reservasi Anda TELAH DIBATALKAN ❌',
                default    => 'Status reservasi Anda diperbarui',
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

    /* =========================
       ADMIN - DELETE
    ========================== */
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
