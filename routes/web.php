<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::latest()->get();
    $settings = SiteSetting::query()->pluck('value', 'key')->all();
    return view('user.home', compact('products', 'settings'));
})->name('home');

Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/policy', function () {
    return view('legal.policy');
})->name('policy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('checkout.stripe.success');
Route::get('/checkout/stripe/cancel', [CheckoutController::class, 'stripeCancel'])->name('checkout.stripe.cancel');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::delete('products/{product}/images', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
        Route::resource('products', ProductController::class);
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/admin', [UserController::class, 'updateAdmin'])->name('users.update-admin');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/download', [ReportController::class, 'download'])->name('reports.download');
        Route::get('site-settings', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
        Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    });
});

require __DIR__.'/auth.php';
