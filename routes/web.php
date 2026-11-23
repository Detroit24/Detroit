<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminTemplateController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes - DETROIT Digital Invitation Studio
|--------------------------------------------------------------------------
*/

// Public Landing Page & Templates
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/template/{slug}', [HomeController::class, 'templateDetail'])->name('template.detail');

// Order & Checkout Flow (3-Step Wizard)
Route::get('/pesan', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pembayaran/{order_code}', [OrderController::class, 'payment'])->name('order.payment');
Route::post('/pembayaran/{order_code}/konfirmasi', [OrderController::class, 'confirmPayment'])->name('order.confirm');
Route::get('/pesanan-berhasil/{order_code}', [OrderController::class, 'success'])->name('order.success');

// Live Digital Invitation
Route::get('/invitation/{slug}', [InvitationController::class, 'show'])->name('invitation.show');
Route::get('/undangan/{slug}', [InvitationController::class, 'show']); // Indonesian alias
Route::get('/demo/{slug}', [InvitationController::class, 'demo'])->name('invitation.demo'); // Demo Template
Route::post('/invitation/{slug}/rsvp', [InvitationController::class, 'rsvp'])->name('invitation.rsvp');
Route::post('/invitation/{slug}/ucapan', [InvitationController::class, 'message'])->name('invitation.message');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Orders
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/pesanan/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/pesanan/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    // Templates
    Route::get('/templates', [AdminTemplateController::class, 'index'])->name('admin.templates.index');
    Route::get('/templates/create', [AdminTemplateController::class, 'create'])->name('admin.templates.create');
    Route::post('/templates', [AdminTemplateController::class, 'store'])->name('admin.templates.store');
    Route::get('/templates/{id}/edit', [AdminTemplateController::class, 'edit'])->name('admin.templates.edit');
    Route::put('/templates/{id}', [AdminTemplateController::class, 'update'])->name('admin.templates.update');
    Route::post('/templates/{id}/toggle', [AdminTemplateController::class, 'toggleActive'])->name('admin.templates.toggle');
    Route::delete('/templates/{id}', [AdminTemplateController::class, 'destroy'])->name('admin.templates.destroy');

    // Categories
    Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/kategori', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/kategori/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/kategori/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Users
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/pengguna/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle');

    // Settings
    Route::get('/pengaturan', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/pengaturan', [AdminSettingController::class, 'update'])->name('admin.settings.update');
});
