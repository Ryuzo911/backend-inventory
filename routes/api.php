<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    
    // Auth Routes
    Route::get('/user/permissions', [PermissionController::class, 'index']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Product Routes with Authorization
    Route::get('/product', [ProductController::class, 'index'])->middleware('can:viewAny, App\Models\Product');
    Route::post('/product', [ProductController::class, 'store'])->middleware('can:create, App\Models\Product');
    Route::get('/product/{product}', [ProductController::class, 'show'])->middleware('can:view, product');
    Route::put('/product/{product}', [ProductController::class, 'update'])->middleware('can:update, product');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->middleware('can:delete, product');

    // Category Routes with Authorization
    Route::get('/category', [CategoryController::class, 'index'])->middleware('can:viewAny, App\Models\Category');
    Route::post('/category', [CategoryController::class, 'store'])->middleware('can:create, App\Models\Category');
    Route::get('/category/{category}', [CategoryController::class, 'show'])->middleware('can:view, category');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('can:update, category');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('can:delete, category');

    // Transaction Routes with Authorization
    Route::get('/transaction', [TransactionController::class, 'index'])->middleware('can:viewAny, App\Models\Transaction');
    Route::post('/transaction', [TransactionController::class, 'store'])->middleware('can:create, App\Models\Transaction');
});
    // Auth Routes
    Route::post('/register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);