<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

// Main Vue app entry point
Route::get('/', function () {
    return view('app');
});

// API Routes (using web.php since api.php isn't loaded)
Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});
