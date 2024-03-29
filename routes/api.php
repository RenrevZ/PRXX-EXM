<?php

use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/fetchAllProduct', [ProductApiController::class, 'getAllproduct']);
    Route::get('/fetchAllCategories', [ProductApiController::class, 'getAllCategories']);
    Route::post('/getSingleCategory', [ProductApiController::class, 'getSingleCategory']);
    Route::get('/searchProduct/{search}', [ProductApiController::class, 'searchProduct']);
    Route::get('/fetchAllproductWithPhoto/{id}', [ProductApiController::class, 'getProductWithPhoto']);
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'destroy']);
});
