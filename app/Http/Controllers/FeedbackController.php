<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Menampilkan halaman form feedback untuk user.
     */
    public function create()
    {
        // Hanya menampilkan view, tidak ada data yang perlu dikirim
        return view('feedback');
    }
}
