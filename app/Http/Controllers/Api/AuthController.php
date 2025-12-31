<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Tambahan untuk akses tabel password_resets
use Illuminate\Support\Str;      // Tambahan untuk generate random string

class AuthController extends Controller
{
    // ============================
    // 1. REGISTER
    // ============================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembeli', 
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    // ============================
    // 2. LOGIN
    // ============================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        if ($user->role !== 'pembeli') {
            return response()->json(['message' => 'Akun ini bukan akun Pembeli.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // ============================
    // 3. LOGOUT
    // ============================
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    // ============================
    // 4. GET USER PROFILE
    // ============================
    public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }

    // ============================
    // 5. UPDATE PROFILE
    // ============================
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile && Storage::exists('public/' . $user->foto_profile)) {
                Storage::delete('public/' . $user->foto_profile);
            }
            $path = $request->file('foto_profile')->store('profile_photos', 'public');
            $user->foto_profile = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }

    // ============================
    // 6. FORGOT PASSWORD (BARU)
    // ============================
    public function forgotPassword(Request $request)
    {
        // 1. Validasi Email
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 2. Buat Token Random
        $token = Str::random(60);

        // 3. Simpan Token ke Database (Table password_reset_tokens)
        // Gunakan updateOrInsert agar jika user request berkali-kali, token lama tertimpa
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token, // Simpan token mentah (opsional: bisa di-hash)
                'created_at' => now()
            ]
        );

        // 4. Return Token di Response (Untuk Testing Mobile)
        // Normalnya ini dikirim via email, tapi untuk kemudahan debug:
        return response()->json([
            'status' => 'success',
            'message' => 'Token reset password berhasil dibuat. Cek response ini untuk tokennya (Mode Debug).',
            'token' => $token, // <--- COPY TOKEN INI UNTUK TESTING DI HP
            'email' => $request->email
        ]);
    }

    // ============================
    // 7. RESET PASSWORD (BARU)
    // ============================
    public function resetPassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // 2. Cek Token di Database
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
             return response()->json(['message' => 'Token tidak valid atau salah email.'], 400);
        }

        // 3. Update Password User
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // 4. Hapus Token (Supaya tidak bisa dipakai lagi)
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password berhasil direset. Silakan login kembali dengan password baru.']);
    }
}