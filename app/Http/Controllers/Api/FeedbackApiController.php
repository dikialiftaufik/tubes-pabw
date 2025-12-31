<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FeedbackApiController extends Controller
{
    /**
     * GET: /api/feedback
     * Mengambil semua data feedback (bisa difilter user di masa depan)
     */
    public function index()
    {
        // Opsi: Jika ingin user hanya melihat feedback miliknya sendiri, gunakan:
        // $data = Feedback::where('id_user', Auth::id())->get();
        
        // Default: Tampilkan semua (sesuai request 'tidak terpaku role')
        $data = Feedback::all();
        
        return response()->json($data, 200);
    }

    /**
     * POST: /api/feedback
     * Menambah feedback baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_masukan' => 'required|string|max:100',
            'pesan_masukan'    => 'required|string',
            'bukti_foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imageName = null;

        // Handle Upload Gambar
        if ($request->hasFile('bukti_foto')) {
            $image = $request->file('bukti_foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/feedback'), $imageName);
            $imageName = 'uploads/feedback/' . $imageName;
        }

        $feedback = Feedback::create([
            'id_user'          => Auth::id(), // Ambil ID dari token login
            'kategori_masukan' => $request->kategori_masukan,
            'pesan_masukan'    => $request->pesan_masukan,
            'tgl_masukan'      => now(),
            'bukti_foto'       => $imageName,
        ]);

        return response()->json([
            'message' => 'Feedback berhasil dikirim',
            'data'    => $feedback
        ], 201);
    }

    /**
     * GET: /api/feedback/{id}
     * Melihat detail feedback
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($feedback, 200);
    }

    /**
     * PUT: /api/feedback/{id}
     * Update data feedback (kecuali foto jika tidak diisi)
     */
    public function update(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi parsial (sometimes)
        $validator = Validator::make($request->all(), [
            'kategori_masukan' => 'sometimes|string|max:100',
            'pesan_masukan'    => 'sometimes|string',
            'bukti_foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update Text
        $feedback->update($request->except(['bukti_foto', 'id_user', 'tgl_masukan']));

        // Handle Update Foto
        if ($request->hasFile('bukti_foto')) {
            // Hapus foto lama
            if ($feedback->bukti_foto && file_exists(public_path($feedback->bukti_foto))) {
                unlink(public_path($feedback->bukti_foto));
            }

            $image = $request->file('bukti_foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/feedback'), $imageName);

            $feedback->bukti_foto = 'uploads/feedback/' . $imageName;
            $feedback->save();
        }

        return response()->json([
            'message' => 'Feedback berhasil diperbarui',
            'data'    => $feedback
        ], 200);
    }

    /**
     * POST: /api/feedback/{id}/upload-foto
     * Method baru khusus upload foto
     */
    public function uploadFoto(Request $request, $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('bukti_foto')) {
            // Hapus foto lama
            if ($feedback->bukti_foto && file_exists(public_path($feedback->bukti_foto))) {
                unlink(public_path($feedback->bukti_foto));
            }

            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/feedback'), $filename);

            $feedback->bukti_foto = 'uploads/feedback/' . $filename;
            $feedback->save();

            return response()->json([
                'message'  => 'Bukti foto berhasil diupload',
                'foto_url' => asset($feedback->bukti_foto),
            ], 200);
        }

        return response()->json(['message' => 'Tidak ada file foto diunggah'], 400);
    }

    /**
     * DELETE: /api/feedback/{id}
     * Hapus feedback dan fotonya
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file fisik
        if ($feedback->bukti_foto && file_exists(public_path($feedback->bukti_foto))) {
            unlink(public_path($feedback->bukti_foto));
        }

        $feedback->delete();

        return response()->json(['message' => 'Feedback berhasil dihapus'], 200);
    }
}