<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // --- SESUAI MODUL LARAVEL AUTH STEP 3 ---

    // Menampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli' // Default role sesuai logika bisnis (pembeli)
        ]);

        // Login otomatis setelah register (Opsional di modul, tapi dipraktikkan)
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/menu');
    }

    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.login'); 
    }

    // Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login (Auth::attempt)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Logika Redirect Berdasarkan Role (Implementasi Studi Kasus Tubes)
            $userRole = Auth::user()->role;

            switch ($userRole) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'kasir':
                    return redirect()->intended('/kasir');
                case 'pembeli':
                    return redirect()->intended('/menu');
                default:
                    return redirect()->intended('/home');
            }
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}