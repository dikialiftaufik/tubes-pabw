<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/menu', [MenuController::class, 'index']);
Route::get('admin/menus', [AdminMenuController::class, 'index']);
Route::get('admin/reports', [ReportController::class, 'salesReport']);
Route::get('admin/notifications', [NotificationController::class, 'index']);
Route::get('admin/feedback', [FeedbackController::class, 'index']);
Route::get('admin/resevations', [ReservationController::class, 'index']);
Route::get('admin/customers', [CustomerController::class, 'index']);
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');