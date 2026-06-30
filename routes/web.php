<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\HomeController;
// This line will be removed as it's a duplicate and causes a naming conflict.
// use App\Http\Controllers\ProductController;use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('brands.show');


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::resource('orders', OrderController::class)->only(['index','show'])->names('admin.orders');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
