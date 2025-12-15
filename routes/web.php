<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DashboardKasirController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StatusPesananController;
use App\Http\Controllers\StatusReservasiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;


// 1. Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('landing');
});

// 2. Auth (Login/Register)
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 3. Route Dashboard Umum (Admin)
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// 4. Group Route ADMIN
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () { // Tambahkan middleware role:admin jika sudah dibuat

    // Kelola Menu
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('admin.menu.index');
    Route::get('/menu/input', [AdminMenuController::class, 'input'])->name('admin.menu.input');
    Route::post('/menu/simpan', [AdminMenuController::class, 'simpan'])->name('admin.menu.simpan');
    Route::get('/menu/edit/{id}', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::post('/menu/update/{id}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::get('/menu/hapus/{id}', [AdminMenuController::class, 'hapus'])->name('admin.menu.hapus');

    // Laporan (Reports)
    Route::get('/reports', [ReportController::class, 'salesReport'])->name('admin.reports.index');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export_excel');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export_pdf');

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('admin.notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('admin.notifications.store');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('admin.notifications.show');
    Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])->name('admin.notifications.edit');
    Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('admin.notifications.update');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');

    // Fitur Lain Admin
    Route::get('/feedback', [AdminFeedbackController::class, 'index']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    Route::get('/customers', [CustomerController::class, 'index']);
});

// 5. Route PUBLIC (Bisa diakses tanpa login)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/detail/{id}', [MenuController::class, 'detail'])->name('menu.detail');
Route::get('/notifications/fetch', [NotificationController::class, 'fetch'])->name('notif.fetch');

// 6. Group Route PEMBELI / USER (Wajib Login)
Route::middleware(['auth'])->group(function () {

    // Feedback User
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index'); // Form Feedback
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store'); // Simpan Feedback

    // Reservasi User
    Route::post('/reservasi/simpan', [ReservationController::class, 'store'])->name('reservasi.simpan');

    //FITUR KERANJANG
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    //FITUR PEMBAYARAN & RIWAYAT
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index'); // Hapus yang lama jika conflic
    Route::post('/checkout', [PembayaranController::class, 'checkout'])->name('checkout.process');
    Route::get('/pembayaran/berhasil', [PembayaranController::class, 'berhasil'])->name('pembayaran.berhasil');

    // Route Halaman Pembayaran (Baru)
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/proses/{id}', [PembayaranController::class, 'proses'])->name('pembayaran.proses');

    // Riwayat
    Route::get('/riwayat-pesanan', [App\Http\Controllers\RiwayatController::class, 'pesanan'])->name('riwayat.pesanan');
    Route::get('/riwayat-reservasi', [App\Http\Controllers\RiwayatController::class, 'reservasi'])->name('riwayat.reservasi');
});

// 7. Group Route KASIR
Route::prefix('kasir')->middleware(['auth'])->group(function () {

    // Dashboard Kasir
    Route::get('/', [DashboardKasirController::class, 'index'])->name('kasir.dashboard');

    // Profil Kasir
    Route::get('/profil', [DashboardKasirController::class, 'profil'])->name('kasir.profil');
    Route::post('/upload-foto', [DashboardKasirController::class, 'uploadFoto'])->name('kasir.upload-foto');
    Route::post('/hapus-foto', [DashboardKasirController::class, 'hapusFoto'])->name('kasir.hapus-foto');

    // Stok Menu
    Route::get('/stok', [KasirController::class, 'stok'])->name('kasir.stok');
    Route::post('/stok/update/{id}', [KasirController::class, 'updateStok'])->name('kasir.update-stok');

    // Status Pesanan & Reservasi
    Route::get('/status-pesanan', [StatusPesananController::class, 'index'])->name('kasir.status-pesanan');
    Route::get('/status-reservasi', [StatusReservasiController::class, 'index'])->name('kasir.status-reservasi');
    Route::put('/status-pesanan/update/{id}', [StatusPesananController::class, 'update'])->name('kasir.status.update');
    Route::post('/reservasi/update/{id}', [StatusReservasiController::class, 'updateStatus'])->name('kasir.reservasi.update');
    Route::post('/reservasi/cancel/{id}', [StatusReservasiController::class, 'cancel'])->name('kasir.reservasi.cancel');
});