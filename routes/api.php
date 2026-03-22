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
use App\Http\Controllers\Api\ApiNotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. PUBLIC ROUTES (Bisa diakses tanpa login) ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/menu', [MenuController::class, 'index']); // PENTING: Menu harus sesuai dengan Flutter '/menu'


// --- 2. PROTECTED ROUTES (Harus Login / Punya Token) ---
Route::middleware('auth:sanctum')->group(function () {

    // Ambil Data User (Untuk Profil & Menampilkan Nama)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);


    // === FITUR PEMBELI & UMUM ===
    // (Saya keluarkan dari middleware 'role:pembeli' sementara agar tidak error 403 saat testing)
    
    // Reservasi (PENTING: URL disamakan dengan Flutter '/reservations')
    Route::get('/reservations', [ReservationApiController::class, 'index']); // History Reservasi
    Route::post('/reservations', [ReservationApiController::class, 'store']); // Buat Reservasi Baru

    // Transaksi & Cart
    Route::post('/cart/add', [TransactionApiController::class, 'addToCart']);
    Route::post('/checkout', [TransactionApiController::class, 'checkout']);
    Route::get('/riwayat-pesanan', [TransactionApiController::class, 'historyPesanan']);
    
    // Feedback
    Route::post('/feedback', [FeedbackApiController::class, 'store']);


    // === ROLE: KASIR ===
    Route::middleware('role:kasir')->prefix('kasir')->group(function () {
        Route::post('/menu/{id}/stok', [KasirApiController::class, 'updateStock']);
        Route::get('/pesanan', [KasirApiController::class, 'getIncomingOrders']);
        Route::post('/pesanan/{id}/status', [KasirApiController::class, 'updateOrderStatus']);
        Route::get('/reservasi', [KasirApiController::class, 'getIncomingReservations']);
        Route::post('/reservasi/{id}/status', [KasirApiController::class, 'updateReservationStatus']);
    });

    // === ROLE: ADMIN ===
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);
        Route::apiResource('menu', AdminMenuController::class);
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/notifications', [ApiNotificationController::class, 'index']);
        Route::get('/feedback', [FeedbackApiController::class, 'index']);
    });

});

Route::post('/pesanan', [PesananController.class, 'store']);
Route::get('/pesanan', [PesananController.class, 'index']);