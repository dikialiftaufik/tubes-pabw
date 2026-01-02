<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationApiController extends Controller
{
    // Middleware auth sudah di routes/api.php
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // Menampilkan daftar reservasi milik user yang login
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau belum login'
            ], 401);
        }

        $reservations = Reservation::where('id_user', $user->id)
            ->with('user:id,name')  // Join ke users jika perlu
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,  // Menggunakan accessor, return id_reservasi
                    'nama_pemesan' => $reservation->name ?? 'Nama Tidak Ditemukan',  // Menggunakan accessor, return nama_pemesan
                    'tgl_reservasi' => $reservation->date ?? null,  // Accessor untuk tgl_reservasi
                    'jam_mulai' => $reservation->time ?? null,  // Accessor untuk jam_mulai
                    'jml_org' => $reservation->people ?? 0,  // Accessor untuk jml_org
                    'catatan' => $reservation->catatan ?? '',  // Jika ada di fillable, tambahkan jika perlu
                    'status' => $reservation->status ?? 'unknown',  // Accessor untuk status_reservasi
                    'created_at' => $reservation->created_at ?? null,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Reservasi Saya',
            'data' => $reservations
        ], 200);
    }

    // Membuat reservasi baru
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        // Validasi sesuai model
        $validator = Validator::make($request->all(), [
            'tgl_reservasi' => 'required|date_format:Y-m-d',
            'jam_mulai' => 'required',
            'jml_org' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $reservation = Reservation::create([
                'id_user' => Auth::id(),  // Tidak null karena Auth::check()
                'nama_pemesan' => Auth::user()->name,  // Isi dari user login, tidak null
                'jml_org' => $request->jml_org,
                'tgl_reservasi' => $request->tgl_reservasi,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai ?? null,  // Jika ada
                'status_reservasi' => 'pending',
                'catatan' => $request->catatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reservasi Berhasil Dibuat',
                'data' => $reservation
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan Server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Tambahkan method lain jika diperlukan
}