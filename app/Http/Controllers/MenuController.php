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
}

