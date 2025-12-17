<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackApiController extends Controller
{
    /**
     * GET /api/feedback
     * Ambil semua feedback milik user yang login
     */
    public function index()
    {
        $feedbacks = Feedback::where('id_user', Auth::id())
            ->orderBy('tgl_masukan', 'desc')
            ->get()
            ->map(function ($f) {
                return [
                    'id' => $f->id_feedback,
                    'kategori' => $f->kategori_masukan,
                    'pesan' => $f->pesan_masukan,
                    'tanggal' => $f->tgl_masukan,
                    'bukti_foto' => $f->bukti_foto,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Daftar feedback berhasil diambil',
            'data' => $feedbacks
        ]);
    }

    /**
     * POST /api/feedback
     * Buat feedback baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_masukan' => 'required|string|max:100',
            'pesan_masukan'    => 'required|string',
            'bukti_foto'       => 'nullable|image|max:2048',
        ]);

        $data = [
            'id_user'          => Auth::id(),
            'tgl_masukan'      => now()->toDateString(),
            'kategori_masukan' => $request->kategori_masukan,
            'pesan_masukan'    => $request->pesan_masukan,
        ];

        // Handle file upload jika ada
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feedback'), $filename);
            $data['bukti_foto'] = 'uploads/feedback/' . $filename;
        }

        $feedback = Feedback::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil dikirim',
            'data' => [
                'id' => $feedback->id_feedback,
                'kategori' => $feedback->kategori_masukan,
                'pesan' => $feedback->pesan_masukan,
                'tanggal' => $feedback->tgl_masukan,
            ]
        ], 201);
    }

    /**
     * GET /api/feedback/{id}
     * Ambil detail feedback tertentu
     */
    public function show($id)
    {
        $feedback = Feedback::where('id_feedback', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$feedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $feedback->id_feedback,
                'kategori' => $feedback->kategori_masukan,
                'pesan' => $feedback->pesan_masukan,
                'tanggal' => $feedback->tgl_masukan,
                'bukti_foto' => $feedback->bukti_foto,
            ]
        ]);
    }

    /**
     * PUT /api/feedback/{id}
     * Update feedback milik user
     */
    public function update(Request $request, $id)
    {
        $feedback = Feedback::where('id_feedback', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$feedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'kategori_masukan' => 'sometimes|string|max:100',
            'pesan_masukan'    => 'sometimes|string',
        ]);

        $feedback->update($request->only(['kategori_masukan', 'pesan_masukan']));

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil diupdate',
            'data' => [
                'id' => $feedback->id_feedback,
                'kategori' => $feedback->kategori_masukan,
                'pesan' => $feedback->pesan_masukan,
                'tanggal' => $feedback->tgl_masukan,
            ]
        ]);
    }

    /**
     * DELETE /api/feedback/{id}
     * Hapus feedback milik user
     */
    public function destroy($id)
    {
        $feedback = Feedback::where('id_feedback', $id)
            ->where('id_user', Auth::id())
            ->first();

        if (!$feedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback tidak ditemukan'
            ], 404);
        }

        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil dihapus'
        ]);
    }
}
