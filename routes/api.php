<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminMenuController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ApiPaymentController;
use App\Http\Controllers\Api\ReservationApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\ApiNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API Login & Register (Public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Menu Public
Route::get('/menu', [MenuController::class, 'index']);

// 3. API Pembayaran
Route::get('/cek-status/{id}', [ApiPaymentController::class, 'checkStatus']);
Route::post('/konfirmasi-bayar', [ApiPaymentController::class, 'confirmPayment']);

// === Group Middleware Auth (Harus Login dengan Token) ===
Route::middleware('auth:sanctum')->group(function () {

    // Logout & User Info
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // === PINDAHKAN ROUTE NOTIFIKASI KE SINI (DI LUAR GRUP ADMIN) ===
    // Agar URL-nya menjadi: http://127.0.0.1:8000/api/notifikasi
    // Dan bisa diakses oleh admin maupun pembeli (sesuai logika controller Anda)
    Route::post('/notifikasi/{id}/upload-foto', [ApiNotificationController::class, 'uploadFoto']);
    Route::apiResource('notifikasi', ApiNotificationController::class);
    // ===============================================================

    // Fitur Pembeli
    Route::middleware('role:pembeli')->group(function () {
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
        Route::apiResource('reservations', ReservationApiController::class);
        Route::apiResource('feedback', FeedbackApiController::class);
    });

    // ----------------------------------------------------
    // ROLE: ADMIN
    // ----------------------------------------------------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // 1. Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // 2. CRUD Menu
        Route::post('/menu/{id}/upload-foto', [AdminMenuController::class, 'uploadFoto']);
        Route::apiResource('menu', AdminMenuController::class);

        // 3. Report Admin 
        Route::get('/laporan', [ReportController::class, 'index']);
        Route::get('/laporan/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('/laporan/export-pdf', [ReportController::class, 'exportPdf']);
    });
});