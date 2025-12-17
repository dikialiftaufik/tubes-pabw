<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * $roles bisa berisi satu role atau beberapa role dipisah koma
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        // Cek apakah role user ada di dalam daftar roles yang diizinkan
        // Jika $roles dikirim sebagai string dipisah koma (seperti di modul)
        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tdk ada hak akses.'
            ], 403);
        }

        return $next($request);
    }
}