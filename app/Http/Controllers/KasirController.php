<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    
    public function index()
    {
        return view('Kasir.index');

    }

    
    public function updateStok(Request $request)
    {

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}
