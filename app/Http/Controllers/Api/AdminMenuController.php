<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Menu',
            'data'    => $menus
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'deskripsi' => 'required',
            'foto'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika validasi gagal, kembalikan error 422
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Proses Upload Gambar
        $imageName = null;
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/menu'), $imageName);
        }

        // 3. Simpan ke Database
        $menu = Menu::create([
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto'      => $imageName
        ]);

        // 4. Response JSON Sukses
        if($menu) {
            return response()->json([
                'success' => true,
                'message' => 'Menu Berhasil Disimpan',
                'data'    => $menu
            ], 201); // 201 artinya Created
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Menu Gagal Disimpan',
            ], 409);
        }
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if ($menu) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Menu',
                'data'    => $menu
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Menu Tidak Ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Cari data menu
        $menu = Menu::find($id);

        if(!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu Tidak Ditemukan',
            ], 404);
        }

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek jika ada file foto baru yang diupload
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if($menu->foto && file_exists(public_path('img/menu/'.$menu->foto))){
                unlink(public_path('img/menu/'.$menu->foto));
            }

            // Upload foto baru
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/menu'), $imageName);

            // Update dengan foto baru
            $menu->update([
                'nama'      => $request->nama,
                'harga'     => $request->harga,
                'stok'      => $request->stok,
                'deskripsi' => $request->deskripsi,
                'foto'      => $imageName
            ]);

        } else {
            // Update tanpa mengubah foto
            $menu->update([
                'nama'      => $request->nama,
                'harga'     => $request->harga,
                'stok'      => $request->stok,
                'deskripsi' => $request->deskripsi,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu Berhasil Diupdate',
            'data'    => $menu
        ], 200);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if($menu) {
            // Hapus file foto
            if($menu->foto && file_exists(public_path('img/menu/'.$menu->foto))){
                unlink(public_path('img/menu/'.$menu->foto));
            }

            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Menu Tidak Ditemukan',
            ], 404);
        }
    }
}