<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; 

class AdminMenuController extends Controller
{
    public function index()
    {
        $data = Menu::all();
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'deskripsi' => 'required',
            'kategori'  => 'required', 
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imageName = null;

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/menu'), $imageName);
            $imageName = 'uploads/menu/' . $imageName; 
        }

        $menu = Menu::create([
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'deskripsi' => $request->deskripsi,
            'kategori'  => $request->kategori,
            'foto'      => $imageName, 
            'bahan'     => $request->bahan ?? '-',
            'kalori'    => $request->kalori ?? 0
        ]);

        return response()->json([
            'message' => 'Menu berhasil ditambahkan (Foto opsional)', 
            'data' => $menu
        ], 201);
    }

    // GET: /api/admin/menu/{id}
    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }
        return response()->json($menu, 200);
    }

    // PUT: /api/admin/menu/{id}
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if(!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }

        $menu->update($request->except(['foto'])); 

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if($menu->foto && file_exists(public_path('img/menu/'.$menu->foto))){
                unlink(public_path('img/menu/'.$menu->foto));
            }
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/menu'), $imageName);
            
            $menu->foto = $imageName;
            $menu->save();
        }

        return response()->json([
            'message' => 'Data diperbarui', 
            'data' => $menu
        ], 200);
    }

    public function uploadFoto(Request $request, $id)
    {
        $menu = Menu::findOrFail($id); 

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('uploads/menu'), $filename);
            
            $menu->foto = 'uploads/menu/' . $filename;
            $menu->save();

            return response()->json([
                'message' => 'Foto berhasil diupload',
                'foto_url' => asset($menu->foto),
            ], 200);
        }

        return response()->json(['message' => 'Tidak ada file foto diunggah'], 400);
    }

    // DELETE: /api/admin/menu/{id}
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if(!$menu) {
            return response()->json(['message' => 'Data tdk ditemukan'], 404);
        }

        if($menu->foto && file_exists(public_path('img/menu/'.$menu->foto))){
            unlink(public_path('img/menu/'.$menu->foto));
        }

        $menu->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}