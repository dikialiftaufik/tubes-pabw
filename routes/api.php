<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminMenuController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ApiPaymentController; // Controller yg sudah ada sebelumnya

// --------------------------------------------------------------------------
// PUBLIC ROUTES
// --------------------------------------------------------------------------

// 1. Auth: Login
Route::post('/login', [AuthController::class, 'login']);

// 2. API Payment (Existing Feature)
Route::get('/cek-status/{id}', [ApiPaymentController::class, 'checkStatus']);
Route::post('/konfirmasi-bayar', [ApiPaymentController::class, 'confirmPayment']);


// --------------------------------------------------------------------------
// PROTECTED ROUTES (Butuh Token Bearer)
// --------------------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Auth: Logout & User Info
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ----------------------------------------------------
    // ROLE: PEMBELI
    // ----------------------------------------------------
    Route::middleware('role:pembeli')->group(function () {
        // Menu untuk Pembeli (Read Only)
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
    });

    // ----------------------------------------------------
    // ROLE: ADMIN
    // ----------------------------------------------------
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        
        // 1. Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // 2. CRUD Menu
        Route::apiResource('menu', AdminMenuController::class);

        // 3. Report Admin (JSON, Excel, PDF)
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/reports/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf']);
    });

});