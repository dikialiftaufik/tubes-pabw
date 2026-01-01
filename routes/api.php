<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminMenuController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ApiNotificationController;
use App\Http\Controllers\Api\ReservationApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\KasirApiController;
use App\Http\Controllers\Api\TransactionApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API Login & Register (Public)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // Tambahan untuk Register di HP

// 2. Group Auth (Harus Login Pakai Token)
Route::middleware('auth:sanctum')->group(function () {

    // Logout & User Info
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // === ROLE: PEMBELI (TUGAS EGA & ZUFAR & DIKI) ===
    Route::middleware('role:pembeli')->group(function () {
        // Menu (Diki)
        Route::get('/pembeli/menu', [MenuController::class, 'index']);
        
        // Transaksi & Keranjang (Tugas Ega)
        Route::post('/cart/add', [TransactionApiController::class, 'addToCart']);
        Route::post('/checkout', [TransactionApiController::class, 'checkout']);
        Route::get('/riwayat-pesanan', [TransactionApiController::class, 'historyPesanan']);
        Route::get('/riwayat-reservasi', [TransactionApiController::class, 'historyReservasi']);

        // Reservasi & Feedback (Zufar)
        Route::post('/reservasi', [ReservationApiController::class, 'store']);
        Route::post('/feedback', [FeedbackApiController::class, 'store']);
    });

    // === ROLE: KASIR (TUGAS EGA) ===
    Route::middleware('role:kasir')->prefix('kasir')->group(function () {
        // Kelola Stok
        Route::post('/menu/{id}/stok', [KasirApiController::class, 'updateStock']);
        
        // Kelola Pesanan (Lihat & Update Status)
        Route::get('/pesanan', [KasirApiController::class, 'getIncomingOrders']);
        Route::post('/pesanan/{id}/status', [KasirApiController::class, 'updateOrderStatus']);
        
        // Kelola Reservasi (Lihat & Update Status)
        Route::get('/reservasi', [KasirApiController::class, 'getIncomingReservations']);
        Route::post('/reservasi/{id}/status', [KasirApiController::class, 'updateReservationStatus']);
    });

    // === ROLE: ADMIN (TUGAS DIKI & ZUFAR) ===
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::apiResource('menu', AdminMenuController::class);
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/notifications', [ApiNotificationController::class, 'index']);
        Route::get('/feedback', [FeedbackApiController::class, 'index']);
    });
});