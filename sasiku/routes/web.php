<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerDashboardController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product detail
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');

// Cart API (public for guests, but will validate on checkout)
Route::prefix('api')->name('api.')->group(function () {
    Route::post('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/validate', [CartController::class, 'validateCart'])->name('cart.validate');
});

// Checkout (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'index'])->name('payment');
    Route::post('/payment/{order}', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    // Specific routes must come before parameterized routes
    Route::get('/products/realtime-prices', [ProductController::class, 'realtimePrices'])->name('products.realtime-prices');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/products/{product}/update-price', [ProductController::class, 'updatePrice'])->name('products.update-price');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/orders/download', [ReportController::class, 'downloadOrders'])->name('reports.orders.download');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// Seller routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [SellerDashboardController::class, 'products'])->name('products');
    Route::get('/products/create', [SellerDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerDashboardController::class, 'storeProduct'])->name('products.store');

    // Orders
    Route::get('/orders', [SellerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [SellerDashboardController::class, 'orderDetail'])->name('orders.show');
    Route::put('/orders/{order}/status', [SellerDashboardController::class, 'updateOrderStatus'])->name('orders.update-status');

    // Earnings
    Route::get('/earnings', [SellerDashboardController::class, 'earnings'])->name('earnings');

    // Profile
    Route::get('/profile', [SellerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [SellerDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');

    // Favorites
    Route::get('/favorites', [CustomerDashboardController::class, 'favorites'])->name('favorites');

    // Profile (override global profile route for customer)
    Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Individual order detail route - accessible to any authenticated user who owns the order
Route::middleware(['auth'])->get('/customer/orders/{order}', [CustomerDashboardController::class, 'orderDetail'])->name('customer.orders.show');

// Profile routes (Breeze default - for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Image compression test route (temporary)
Route::get('/test-image-compression', [\App\Http\Controllers\ImageUploadTestController::class, 'showForm']);
Route::post('/test-image-compression', [\App\Http\Controllers\ImageUploadTestController::class, 'handleUpload']);

// Authentication routes (Breeze)
require __DIR__.'/auth.php';
