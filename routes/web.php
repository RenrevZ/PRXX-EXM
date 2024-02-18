<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web', 'check_remember_me'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    });
});

Route::middleware('auth')->group(function () {
    // PRODUCTS ROUTE
    Route::prefix('/products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/create', [ProductController::class, 'store'])->name('product.store');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    });

    // VIDEO ROUTE
    Route::get('/Video', [VideoController::class, 'index']);
});

require __DIR__ . '/auth.php';
