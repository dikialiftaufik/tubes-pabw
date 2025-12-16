<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Mengambil semua data menu
        $menus = Menu::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar Menu (Pembeli)',
            'data' => $menus
        ], 200);
    }
}