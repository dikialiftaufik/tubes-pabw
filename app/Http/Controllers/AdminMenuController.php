<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\File;

class AdminMenuController extends Controller
{
    public function index()
    {
        $dt_menu = Menu::all();
        return view('admin.menu', compact('dt_menu'));
    }

    public function input()
    {
        return view('admin.input_menu'); 
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'bahan' => 'required',
            'kalori' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/menu'), $filename);
            
            $data['foto'] = $filename;
        }

        Menu::create($data);

        return redirect('/admin/menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('admin.edit_menu', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        $request->validate([
            'nama' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'harga' => 'required|numeric',
            'bahan' => 'required', 
            'kalori' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($menu->foto && File::exists(public_path('img/menu/' . $menu->foto))) {
                File::delete(public_path('img/menu/' . $menu->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/menu'), $filename);
            $data['foto'] = $filename;
        } else {
            unset($data['foto']);
        }

        if (!$request->has('stok')) {
            unset($data['stok']); 
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diupdate');
    }

    public function hapus($id)
    {
        $menu = Menu::find($id);

        if ($menu->foto && File::exists(public_path('img/menu/' . $menu->foto))) {
            File::delete(public_path('img/menu/' . $menu->foto));
        }

        $menu->delete();

        return redirect('/admin/menu');
    }
}
