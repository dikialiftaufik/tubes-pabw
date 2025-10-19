<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
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
Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');