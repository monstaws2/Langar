<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\MotorcycleModelController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

// Admin routes - protected by auth and admin middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Brands
    Route::resource('brands', BrandController::class);

    // Motorcycle Models
    Route::resource('motorcycle-models', MotorcycleModelController::class);

    // Orders
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'destroy']);
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{user}', [CustomerController::class, 'show'])->name('customers.show');

    // Inventory
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('inventory/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('inventory/logs', [InventoryController::class, 'logs'])->name('inventory.logs');
    Route::get('inventory/export', [InventoryController::class, 'export'])->name('inventory.export');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});