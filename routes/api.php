<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminMenuController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ApiPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API Login (Public)
Route::post('/login', [AuthController::class, 'login']);

// === API PEMBAYARAN (Punya Anda) ===
// Ditaruh di luar 'auth:sanctum' agar bisa dites Postman (Simulasi Bank) tanpa perlu login token
Route::get('/cek-status/{id}', [ApiPaymentController::class, 'checkStatus']);
Route::post('/konfirmasi-bayar', [ApiPaymentController::class, 'confirmPayment']);


// === Group Middleware Auth (Harus Login) ===
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Cek User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 2. FITUR UNTUK PEMBELI (Role: Pembeli)
    Route::middleware('role:pembeli')->group(function () {
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
    });

    // 3. FITUR UNTUK ADMIN (Role: Admin)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // A. Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // B. CRUD Menu
        Route::apiResource('menu', AdminMenuController::class);

        // C. Report Admin
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/reports/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf']);
    });
});