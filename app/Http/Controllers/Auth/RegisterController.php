<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani pendaftaran user baru serta validasinya.
    | Secara default, controller ini menggunakan trait untuk menyediakan
    | fungsionalitas ini tanpa perlu repot menulis kode dari awal.
    |
    */

    use RegistersUsers;

    /**
     * Setelah register berhasil, user akan diarahkan ke sini.
     * Kita set ke halaman '/' (Landing Page) atau '/menu'.
     *
     * @var string
     */
    protected $redirectTo = '/menu'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // MODIFIKASI: Menambahkan 'role' => 'pembeli' secara otomatis
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'pembeli', // <-- Ini kuncinya agar otomatis jadi pembeli
        ]);
    }
}