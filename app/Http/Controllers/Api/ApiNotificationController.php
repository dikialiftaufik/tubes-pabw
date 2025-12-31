<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Pastikan import ini ada jika nanti menggunakan Storage, tapi kita pakai public_path sesuai referensi

class ApiNotificationController extends Controller
{
    /**
     * GET: /api/notifikasi
     * Mengambil semua data notifikasi
     */
    public function index(Request $request)
    {
        // Ambil User yang sedang login dari Token
        $user = $request->user();

        // Ambil notifikasi milik user tersebut saja
        // Pastikan nama kolom di database adalah 'id_user' (sesuai SQL yang Anda kirim)
        $notifications = Notifikasi::where('id_user', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

    /**
     * POST: /api/notifikasi
     * Menambah notifikasi baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_notifikasi'  => 'required|string|max:150',
            'pesan_notifikasi'  => 'required|string',
            'id_user'           => 'required|exists:users,id', // Pastikan user tujuan ada
            'gambar_notifikasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imageName = null;

        // Handle Upload Gambar
        if ($request->hasFile('gambar_notifikasi')) {
            $image = $request->file('gambar_notifikasi');
            // Penamaan file unik dengan timestamp
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Pindahkan ke folder public/uploads/notifikasi
            $image->move(public_path('uploads/notifikasi'), $imageName);
            // Simpan path relatif untuk database
            $imageName = 'uploads/notifikasi/' . $imageName;
        }

        $notifikasi = Notifikasi::create([
            'id_user'           => $request->id_user,
            'judul_notifikasi'  => $request->judul_notifikasi,
            'pesan_notifikasi'  => $request->pesan_notifikasi,
            'gambar_notifikasi' => $imageName,
        ]);

        return response()->json([
            'message' => 'Notifikasi berhasil ditambahkan',
            'data'    => $notifikasi
        ], 201);
    }

    /**
     * GET: /api/notifikasi/{id}
     * Melihat detail notifikasi spesifik
     */
    public function show($id)
    {
        $notifikasi = Notifikasi::find($id);
        
        if (!$notifikasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        
        return response()->json($notifikasi, 200);
    }

    /**
     * PUT: /api/notifikasi/{id}
     * Update data notifikasi (kecuali foto jika tidak diisi, atau replace jika diisi)
     */
    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::find($id);
        
        if (!$notifikasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Validasi input (tanpa required agar bisa update parsial)
        $validator = Validator::make($request->all(), [
            'judul_notifikasi'  => 'sometimes|string|max:150',
            'pesan_notifikasi'  => 'sometimes|string',
            'id_user'           => 'sometimes|exists:users,id',
            'gambar_notifikasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update field teks
        $notifikasi->update($request->except(['gambar_notifikasi']));

        // Handle Update Foto jika ada file baru yang dikirim
        if ($request->hasFile('gambar_notifikasi')) {
            // Hapus foto lama jika ada
            if ($notifikasi->gambar_notifikasi && file_exists(public_path($notifikasi->gambar_notifikasi))) {
                unlink(public_path($notifikasi->gambar_notifikasi));
            }

            $image = $request->file('gambar_notifikasi');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/notifikasi'), $imageName);
            
            $notifikasi->gambar_notifikasi = 'uploads/notifikasi/' . $imageName;
            $notifikasi->save();
        }

        return response()->json([
            'message' => 'Data notifikasi diperbarui',
            'data'    => $notifikasi
        ], 200);
    }

    /**
     * POST: /api/notifikasi/{id}/upload-foto
     * Khusus untuk upload/ganti foto saja
     */
    public function uploadFoto(Request $request, $id)
    {
        $notifikasi = Notifikasi::find($id);

        if (!$notifikasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'gambar_notifikasi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('gambar_notifikasi')) {
            // Hapus foto lama jika ada
            if ($notifikasi->gambar_notifikasi && file_exists(public_path($notifikasi->gambar_notifikasi))) {
                unlink(public_path($notifikasi->gambar_notifikasi));
            }

            $file = $request->file('gambar_notifikasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/notifikasi'), $filename);
            
            $notifikasi->gambar_notifikasi = 'uploads/notifikasi/' . $filename;
            $notifikasi->save();

            return response()->json([
                'message' => 'Foto notifikasi berhasil diupload',
                'foto_url' => asset($notifikasi->gambar_notifikasi),
            ], 200);
        }

        return response()->json(['message' => 'Tidak ada file foto diunggah'], 400);
    }

    /**
     * DELETE: /api/notifikasi/{id}
     * Hapus notifikasi dan gambarnya
     */
    public function destroy($id)
    {
        $notifikasi = Notifikasi::find($id);
        
        if (!$notifikasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus file fisik gambar jika ada
        if ($notifikasi->gambar_notifikasi && file_exists(public_path($notifikasi->gambar_notifikasi))) {
            unlink(public_path($notifikasi->gambar_notifikasi));
        }

        $notifikasi->delete();
        
        return response()->json(['message' => 'Data notifikasi berhasil dihapus'], 200);
    }
}