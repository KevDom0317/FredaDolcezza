<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rutas públicas del menú
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/producto/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/categoria/{id}', [MenuController::class, 'category'])->name('menu.category');

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
    });
});

require __DIR__.'/auth.php';
