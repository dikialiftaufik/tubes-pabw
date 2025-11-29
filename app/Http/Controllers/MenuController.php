<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index()
    {    
        $dt_menu = Menu::all();
        return view('menu', compact('dt_menu'));
    }

    public function detail($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('menu.index')->with('error', 'Menu tidak ditemukan');
        }
        return view('menu_detail', compact('menu'));
    }
}

