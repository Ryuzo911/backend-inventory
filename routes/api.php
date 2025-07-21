<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    
    Route::get('/user', function (Request $request) {
        return $request->user();});
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('product', ProductController::class);
    Route::apiResource('transaction', TransactionController::class);
    Route::apiResource('category', CategoryController::class);
});

Route::post('login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);