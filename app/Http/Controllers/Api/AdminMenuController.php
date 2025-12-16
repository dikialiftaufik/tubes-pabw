<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMenuController extends Controller
{
    // GET: /api/admin/menu
    public function index()
    {
        // Sesuai modul, variabel menggunakan nama umum $data
        $data = Menu::all();
        
        return response()->json($data, 200);
    }

    // POST: /api/admin/menu
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'deskripsi' => 'required',
            'foto'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload Gambar
        $imageName = null;
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/menu'), $imageName);
        }

        // Simpan data (Variable $menu merepresentasikan entity tunggal)
        $menu = Menu::create([
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'stok'      => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto'      => $imageName
        ]);

        // Format return sesuai modul: message & data
        return response()->json([
            'message' => 'Menu berhasil ditambahkan', 
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

        // Logika update foto
        if ($request->hasFile('foto')) {
            if($menu->foto && file_exists(public_path('img/menu/'.$menu->foto))){
                unlink(public_path('img/menu/'.$menu->foto));
            }
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/menu'), $imageName);
            
            $menu->foto = $imageName;
        }

        // Update field lainnya
        $menu->update($request->except(['foto'])); // Update semua kecuali foto yg sudah dihandle
        if(isset($imageName)) $menu->save(); // Simpan foto jika ada perubahan

        return response()->json([
            'message' => 'Data diperbarui', 
            'data' => $menu
        ], 200);
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