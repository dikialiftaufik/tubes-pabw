<?php

namespace App\Http\Controllers;

class StatusPesananController extends Controller
{
    public function index()
    {
        return view('kasir.status-pesanan');
    }
}
