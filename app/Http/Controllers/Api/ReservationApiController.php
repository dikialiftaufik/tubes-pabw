<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class ReservationApiController extends Controller
{
    /**
     * GET /api/reservations
     * Ambil semua reservasi milik user yang login
     */
    public function index()
    {
        $reservations = Reservation::where('id_user', Auth::id())
            ->orderBy('tgl_reservasi', 'desc')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id_reservasi,
                    'nama_pemesan' => $r->nama_pemesan,
                    'jumlah_orang' => $r->jml_org,
                    'tanggal' => $r->tgl_reservasi,
                    'jam_mulai' => $r->jam_mulai,
                    'status' => $r->status_reservasi,
                    'created_at' => $r->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar reservasi berhasil diambil',
            'data' => $reservations
        ]);
    }

    /**
     * POST /api/reservations
     * Buat reservasi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'jml_org'       => 'required|integer|min:1',
            'tgl_reservasi' => 'required|date|after_or_equal:today',
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

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil dibuat',
            'data' => [
                'id' => $reservation->id_reservasi,
                'nama_pemesan' => $reservation->nama_pemesan,
                'jumlah_orang' => $reservation->jml_org,
                'tanggal' => $reservation->tgl_reservasi,
                'jam_mulai' => $reservation->jam_mulai,
                'status' => $reservation->status_reservasi,
            ]
        ], 201);
    }

    /**
     * GET /api/reservations/{id}
     * Ambil detail reservasi tertentu
     */
    public function show($id)
    {
        $reservation = Reservation::where('id_reservasi', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reservation->id_reservasi,
                'nama_pemesan' => $reservation->nama_pemesan,
                'jumlah_orang' => $reservation->jml_org,
                'tanggal' => $reservation->tgl_reservasi,
                'jam_mulai' => $reservation->jam_mulai,
                'status' => $reservation->status_reservasi,
                'created_at' => $reservation->created_at,
            ]
        ]);
    }

    /**
     * PUT /api/reservations/{id}
     * Update reservasi (hanya jika status masih pending)
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::where('id_reservasi', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        }

        if ($reservation->status_reservasi !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak dapat diubah karena sudah diproses'
            ], 400);
        }

        $request->validate([
            'jml_org'       => 'sometimes|integer|min:1',
            'tgl_reservasi' => 'sometimes|date|after_or_equal:today',
            'jam_mulai'     => 'sometimes',
        ]);

        $reservation->update($request->only(['jml_org', 'tgl_reservasi', 'jam_mulai']));

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil diupdate',
            'data' => [
                'id' => $reservation->id_reservasi,
                'nama_pemesan' => $reservation->nama_pemesan,
                'jumlah_orang' => $reservation->jml_org,
                'tanggal' => $reservation->tgl_reservasi,
                'jam_mulai' => $reservation->jam_mulai,
                'status' => $reservation->status_reservasi,
            ]
        ]);
    }

    /**
     * DELETE /api/reservations/{id}
     * Batalkan reservasi (hanya jika status masih pending)
     */
    public function destroy($id)
    {
        $reservation = Reservation::where('id_reservasi', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan'
            ], 404);
        }

        if ($reservation->status_reservasi !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak dapat dibatalkan karena sudah diproses'
            ], 400);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil dibatalkan'
        ]);
    }
}
