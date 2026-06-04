<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::get('/seller/login', [AuthController::class, 'createSeller'])->name('seller.login');
    Route::get('/admin/login', [AuthController::class, 'createAdmin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Order History Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Seller Routes
    Route::middleware(['role:seller'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Web\Seller\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [\App\Http\Controllers\Web\Seller\DashboardController::class, 'products'])->name('products.index');
        Route::get('/orders', [\App\Http\Controllers\Web\Seller\DashboardController::class, 'orders'])->name('orders.index');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/products', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'products'])->name('products.index');
        Route::get('/categories', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'categories'])->name('categories.index');
        Route::get('/orders', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'orders'])->name('orders.index');
        Route::get('/users', [\App\Http\Controllers\Web\Admin\DashboardController::class, 'users'])->name('users.index');
    });
});
