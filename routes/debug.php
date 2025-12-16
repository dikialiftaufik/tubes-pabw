<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-session', function () {
    return response()->json([
        'session_driver' => config('session.driver'),
        'session_secure' => config('session.secure'),
        'session_domain' => config('session.domain'),
        'session_same_site' => config('session.same_site'),
        'app_url' => config('app.url'),
        'auth_check' => auth()->check(),
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
    ]);
});
