<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

// Handle preflight requests for all routes
Route::options('/{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept');
})->where('any', '.*');

// Test route
Route::get('/test', function() {
    return response()->json([
        'message' => 'API is working!',
        'status' => 'success'
    ]);
});

// Post routes
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Category routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

// Stats route
Route::get('/stats', function() {
    return response()->json([
        'posts' => \App\Models\Post::count(),
        'categories' => \App\Models\Category::count(),
        'users' => \App\Models\User::count(),
        'comments' => \App\Models\Comment::count(),
    ]);
});