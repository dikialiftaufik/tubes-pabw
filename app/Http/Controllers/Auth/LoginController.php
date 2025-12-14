<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // <-- Jangan lupa baris ini

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani autentikasi user untuk aplikasi dan
    | mengarahkan mereka ke layar beranda. Controller ini menggunakan trait
    | untuk menyediakan fungsionalitasnya.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been authenticated.
     * Logika Redirect Berdasarkan Role (Sesuai Materi Dosen)
     */
    protected function authenticated(Request $request, $user)
    {
        // Jika user adalah Admin
        if ($user->role == 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // Jika user adalah Kasir
        if ($user->role == 'kasir') {
            return redirect()->intended('/kasir');
        }

        // Jika user adalah Pembeli (Default)
        return redirect()->intended('/menu');
    }
}