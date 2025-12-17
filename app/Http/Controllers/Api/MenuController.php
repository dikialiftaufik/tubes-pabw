<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // User hanya perlu melihat daftar menu
    public function index()
    {
        $menus = Menu::all();
        return response()->json([
            'status' => 'success',
            'data' => $menus
        ]);
    }

}