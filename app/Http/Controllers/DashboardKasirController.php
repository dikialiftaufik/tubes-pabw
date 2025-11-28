<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardKasirController extends Controller
{
    public function index()
    {
        return view('Kasir.dashboard');
    }
}
