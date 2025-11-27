<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\StatusPesananController;
use App\Http\Controllers\StatusReservasiController;
use App\Http\Controllers\DashboardKasirController;




Route::get('/', function () {
    return view('landing');
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/dashboard', [DashboardController::class, 'index']);
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::get('admin/menus', [AdminMenuController::class, 'index']);
Route::get('admin/reports', [ReportController::class, 'salesReport']);
Route::get('admin/notifications', [NotificationController::class, 'index']);
Route::get('admin/feedback', [AdminFeedbackController::class, 'index']);
Route::get('admin/resevations', [ReservationController::class, 'index']);
Route::get('admin/customers', [CustomerController::class, 'index']);
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('/pembayaran/berhasil', [PembayaranController::class, 'berhasil'])->name('pembayaran.berhasil');
Route::get('/kasir/status-pesanan', [StatusPesananController::class, 'index'])
     ->name('kasir.status-pesanan');
Route::get('/kasir/status-reservasi', [StatusReservasiController::class, 'index'])
    ->name('kasir.status-reservasi');
Route::get('/kasir/dashboard', [DashboardKasirController::class, 'index'])
     ->name('kasir.dashboard');

