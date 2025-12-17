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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API Login & Register (Public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Menu Public (Agar bisa diakses GET http://127.0.0.1:8001/api/menu)
Route::get('/menu', [MenuController::class, 'index']);

// 3. API Pembayaran (Public Test)
Route::get('/cek-status/{id}', [ApiPaymentController::class, 'checkStatus']);
Route::post('/konfirmasi-bayar', [ApiPaymentController::class, 'confirmPayment']);

// === Group Middleware Auth (Harus Login dengan Token) ===
Route::middleware('auth:sanctum')->group(function () {

    // Logout & User Info
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Fitur Pembeli
    Route::middleware('role:pembeli')->group(function () {
        // Jika ingin spesifik path pembeli
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
        
        // API Reservasi untuk Pembeli
        Route::apiResource('reservations', ReservationApiController::class);
    });

    // ----------------------------------------------------
    // ROLE: ADMIN
    // ----------------------------------------------------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // 1. Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // 2. CRUD Menu
        // Route khusus upload foto (HARUS didefinisikan sebelum apiResource atau secara eksplisit)
        Route::post('/menu/{id}/upload-foto', [AdminMenuController::class, 'uploadFoto']);
        Route::apiResource('menu', AdminMenuController::class);

        // 3. Report Admin 
        // Mengubah 'reports' menjadi 'laporan' agar sesuai URL Postman Anda
        Route::get('/laporan', [ReportController::class, 'index']);
        Route::get('/laporan/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('/laporan/export-pdf', [ReportController::class, 'exportPdf']);
    });
});