<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminMenuController extends Controller
{
    // READ (List)
    public function index()
    {
        $menus = Menu::all();
        return response()->json(['success' => true, 'data' => $menus], 200);
    }

    // CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'deskripsi' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $input = $request->all();

        // Upload Foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/menu'), $filename); // Simpan di public/img/menu sesuai struktur existing
            $input['foto'] = $filename;
        }

        $menu = Menu::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'data' => $menu
        ], 201);
    }

    // SHOW (Detail)
    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu) return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);

        return response()->json(['success' => true, 'data' => $menu], 200);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);

        $validator = Validator::make($request->all(), [
            'nama' => 'string',
            'harga' => 'numeric',
            'stok' => 'integer',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $input = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika perlu
            if ($menu->foto && file_exists(public_path('img/menu/' . $menu->foto))) {
                unlink(public_path('img/menu/' . $menu->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/menu'), $filename);
            $input['foto'] = $filename;
        }

        $menu->update($input);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diupdate',
            'data' => $menu
        ], 200);
    }

    // DELETE
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);

        if ($menu->foto && file_exists(public_path('img/menu/' . $menu->foto))) {
            unlink(public_path('img/menu/' . $menu->foto));
        }

        $menu->delete();

        return response()->json(['success' => true, 'message' => 'Menu berhasil dihapus'], 200);
    }
}