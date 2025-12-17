<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|string'
        ]);

        $menu = Menu::create($validated);

        return response()->json([
            'message' => 'Data menu ditambahkan',
            'data' => $menu
        ], 201);
    }

    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }

        $menu->update($request->all());

        return response()->json([
            'message' => 'Data diperbarui',
            'data' => $menu
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }
        $menu->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // Method khusus uploadFoto sesuai modul
    public function uploadFoto(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($request->hasFile('gambar')) { // Sesuaikan nama field 'gambar' atau 'foto'
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menu'), $filename);
            
            $menu->gambar = 'uploads/menu/' . $filename;
            $menu->save();

            return response()->json([
                'message' => 'Foto berhasil diupload',
                'foto_url' => asset($menu->gambar)
            ], 200);
        }

        return response()->json(['message' => 'Tidak ada file foto diunggah'], 400);
    }
}