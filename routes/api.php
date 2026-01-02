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
use App\Http\Controllers\Api\PesananController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API Login & Register (Public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// 2. Menu Public
Route::get('/menu', [MenuController::class, 'index']);

// 3. API Pembayaran
Route::get('/cek-status/{id}', [ApiPaymentController::class, 'checkStatus']);
Route::post('/konfirmasi-bayar', [ApiPaymentController::class, 'confirmPayment']);

// === Group Middleware Auth (Harus Login dengan Token) ===
Route::middleware('auth:sanctum')->group(function () {

    // Logout & User Info
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userProfile']); // Lihat Profil
    Route::post('/user/update', [AuthController::class, 'updateProfile']); // Edit Profil (Perlu POST untuk handle file upload di Mobile lebih mudah)

    // === FITUR UMUM (Bisa akses semua role yg login) ===

    // 1. Notifikasi
    Route::post('/notifications/{id}/upload-foto', [ApiNotificationController::class, 'uploadFoto']);
    Route::apiResource('notifications', ApiNotificationController::class);

    // 2. Feedback (DIPINDAHKAN KE SINI - Tidak terpaku role pembeli)
    Route::post('/feedback/{id}/upload-foto', [FeedbackApiController::class, 'uploadFoto']);
    Route::apiResource('feedback', FeedbackApiController::class);


    // === FITUR KHUSUS ROLE ===

    // Fitur Pembeli
    Route::middleware('role:pembeli')->group(function () {
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
        Route::apiResource('reservations', ReservationApiController::class);
        // Feedback dipindah ke atas (umum)
    });

    // Fitur Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::post('/menu/{id}/upload-foto', [AdminMenuController::class, 'uploadFoto']);
        Route::apiResource('menu', AdminMenuController::class);
        Route::get('/laporan', [ReportController::class, 'index']);
        Route::get('/laporan/export-excel', [ReportController::class, 'exportExcel']);
        Route::get('/laporan/export-pdf', [ReportController::class, 'exportPdf']);
    });
});

Route::post('/pesanan', [PesananController.class, 'store']);
Route::get('/pesanan', [PesananController.class, 'index']);