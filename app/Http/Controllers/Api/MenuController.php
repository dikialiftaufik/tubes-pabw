<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar Menu Berhasil Diambil',
            'data' => $menus
        ], 200);
    }
}