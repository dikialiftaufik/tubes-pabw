<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SessionDebugMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession()) {
            Log::info('SESSION_DEBUG', [
                'url' => $request->url(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId(),
                'user_id' => Auth::id(),
                'auth_check' => Auth::check()
            ]);
        } else {
            Log::warning('SESSION_DEBUG: No session store set on request', ['url' => $request->url()]);
        }

        return $next($request);
    }
}
