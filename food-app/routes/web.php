<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rutas públicas del menú
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/producto/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/categoria/{id}', [MenuController::class, 'category'])->name('menu.category');

// Rutas del carrito
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{productId}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{productId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Rutas de checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// Rutas públicas de pedidos
Route::get('/pedido/{id}', [OrderStatusController::class, 'show'])->name('order.status');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de administración
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('admin.index');
        })->name('index');
        
        // Rutas de categorías
        Route::resource('categories', CategoryController::class);
        
        // Rutas de productos
        Route::resource('products', ProductController::class);
        
        // Rutas de pedidos
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});

require __DIR__.'/auth.php';
