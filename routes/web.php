<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UmkmController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Auth routes
Auth::routes();

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Arahkan ke form pengisian data toko (bukan langsung ubah role)
    Route::post('/become-umkm', [HomeController::class, 'becomeUmkm'])->name('become.umkm');

    // Form pendaftaran UMKM
    Route::get('/umkm/register', [HomeController::class, 'showUmkmRegistrationForm'])->name('umkm.registerForm');
    Route::post('/umkm/register', [HomeController::class, 'storeUmkmRegistration'])->name('umkm.registerStore');

    // Order routes (for buyers)
    Route::get('/checkout/{product}', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// UMKM routes
Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [UmkmController::class, 'profile'])->name('profile');
    Route::match(['put', 'post'], '/profile', [UmkmController::class, 'updateProfile'])->name('profile.update');

    // Product management
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [UmkmController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [UmkmController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [UmkmController::class, 'updateOrderStatus'])->name('orders.updateStatus');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::put('/products/{product}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
    Route::put('/products/{product}/reject', [AdminController::class, 'rejectProduct'])->name('products.reject');
});

// Ini diletakkan terakhir agar tidak mengganggu /umkm/{prefix}
Route::get('/umkm/{user}', [UmkmController::class, 'showStoreProfile'])->name('umkm.profile.show');


