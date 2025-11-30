<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminMenuController;
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

// Route Admin 
Route::prefix('admin')->group(function () {
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('admin.menu.index');
    Route::get('/menu/input', [AdminMenuController::class, 'input'])->name('admin.menu.input');
    Route::post('/menu/simpan', [AdminMenuController::class, 'simpan'])->name('admin.menu.simpan');
    Route::get('/menu/edit/{id}', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::post('/menu/update/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::get('/menu/hapus/{id}', [AdminMenuController::class, 'hapus'])->name('admin.menu.hapus');
    
    Route::get('/reports', [ReportController::class, 'salesReport'])->name('admin.reports.index');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export_excel');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export_pdf');
});



// Route User 
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/detail/{id}', [MenuController::class, 'detail'])->name('menu.detail');

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::get('admin/notifications', [NotificationController::class, 'index']);
Route::get('admin/feedback', [AdminFeedbackController::class, 'index']);
Route::get('admin/resevations', [ReservationController::class, 'index']);
Route::get('admin/customers', [CustomerController::class, 'index']);
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::get('/pembayaran/berhasil', [PembayaranController::class, 'berhasil'])->name('pembayaran.berhasil');
Route::prefix('kasir')->group(function () {

    Route::get('/', [DashboardKasirController::class, 'index'])->name('kasir.dashboard');

    Route::get('/profil', [DashboardKasirController::class, 'profil'])->name('kasir.profil');
    Route::post('/upload-foto', [DashboardKasirController::class, 'uploadFoto'])->name('kasir.upload-foto');
    Route::post('/hapus-foto', [DashboardKasirController::class, 'hapusFoto'])->name('kasir.hapus-foto');

    Route::get('/stok', [KasirController::class, 'index'])->name('kasir.stok');

    // FIX TERPENTING!!
    Route::get('/status-pesanan', [KasirController::class, 'pesanan'])->name('kasir.status-pesanan');
    Route::get('/status-reservasi', [KasirController::class, 'reservasi'])->name('kasir.status-reservasi');
});


