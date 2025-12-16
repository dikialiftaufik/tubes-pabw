<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionDiagnosticController extends Controller
{
    public function check(Request $request)
    {
        $data = [
            '=== CONFIGURATION ===' => '',
            'session.driver' => config('session.driver'),
            'session.lifetime' => config('session.lifetime'),
            'session.secure' => config('session.secure') ? 'true' : 'false',
            'session.http_only' => config('session.http_only') ? 'true' : 'false',
            'session.same_site' => config('session.same_site'),
            'session.domain' => config('session.domain') ?? 'null',
            'session.path' => config('session.path'),
            'app.url' => config('app.url'),

            '=== RUNTIME STATE ===' => '',
            'current_url' => url()->current(),
            'request_url' => $request->url(),
            'session.has_session' => $request->hasSession() ? 'YES' : 'NO',
            'session.id' => session()->getId() ?? 'NULL',
            'auth.check' => Auth::check() ? 'YES' : 'NO',
            'auth.id' => Auth::id() ?? 'NULL',
            'auth.user.name' => Auth::user()->name ?? 'NULL',
            'auth.user.role' => Auth::user()->role ?? 'NULL',

            '=== COOKIE INFO ===' => '',
            'cookies_sent' => count($request->cookies->all()),
            'cookie_names' => implode(', ', array_keys($request->cookies->all())),
        ];

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function test(Request $request)
    {
        // Test: Write to session
        session(['diagnostic_test' => 'value_' . time()]);

        return response()->json([
            'message' => 'Session test value written',
            'test_value' => session('diagnostic_test'),
            'session_id' => session()->getId(),
        ]);
    }

    public function verify(Request $request)
    {
        return response()->json([
            'message' => 'Verifying session persistence',
            'test_value_exists' => session()->has('diagnostic_test'),
            'test_value' => session('diagnostic_test') ?? 'NOT FOUND',
            'session_id' => session()->getId(),
        ]);
    }

    public function viewLogs(Request $request)
    {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            return response('Log file not found', 404);
        }

        // Read last 200 lines
        $lines = [];
        $file = new \SplFileObject($logFile, 'r');
        $file->seek(PHP_INT_MAX);
        $last_line = $file->key();
        $start = max(0, $last_line - 200);

        $file->seek($start);
        while (!$file->eof()) {
            $lines[] = $file->current();
            $file->next();
        }

        $content = implode('', $lines);

        // Filter untuk PAYMENT PROSES logs
        $filtered = array_filter(explode("\n", $content), function ($line) {
            return stripos($line, 'PAYMENT PROSES') !== false
                || stripos($line, 'session') !== false
                || stripos($line, 'auth') !== false;
        });

        return response('<pre>' . htmlspecialchars(implode("\n", $filtered)) . '</pre>');
    }
}
