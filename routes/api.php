<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Models\User;

// Route::prefix('auth')->group(function () {
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//     Route::get('/user', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');
// });

// Route::middleware('auth:sanctum')->group(function () {
//     // User routes
//     Route::get('/users', [UserController::class, 'index']);
//     Route::get('/users/{id}', [UserController::class, 'show']);
//     Route::put('/users/{id}', [UserController::class, 'update']);
//     Route::delete('/users/{id}', [UserController::class, 'destroy']);

//     // Product routes
//     Route::get('/products', [ProductController::class, 'index']);
//     Route::post('/products', [ProductController::class, 'store']);
//     Route::get('/products/{id}', [ProductController::class, 'show']);
//     Route::put('/products/{id}', [ProductController::class, 'update']);
//     Route::delete('/products/{id}', [ProductController::class, 'destroy']);
// });

// Route::middleware('auth:sanctum')->group(function () {
//     // User routes
//     // Route::get('/users', [UserController::class, 'index']);
//     // Route::get('/users/{id}', [UserController::class, 'show']);
//     // Route::put('/users/{id}', [UserController::class, 'update']);
//     // Route::delete('/users/{id}', [UserController::class, 'destroy']);

//     // Product routes
//     Route::get('/products', [ApiProductController::class, 'index']);
//     // Route::post('/products', [ProductController::class, 'store']);
//     // Route::get('/products/{id}', [ProductController::class, 'show']);
//     // Route::put('/products/{id}', [ProductController::class, 'update']);
//     // Route::delete('/products/{id}', [ProductController::class, 'destroy']);
// });

// Route::get('/test', function () {
//     return response()->json(['message' => 'API working']);
// });

// Route::middleware(['checkApiKey'])->group(function(){
//     Route::get('/products', [ProductController::class, 'index']);
// });

Route::prefix('auth')->group(function(){
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::delete('/logout', [AuthController::class,'logout']);
    
});



Route::middleware('auth:sanctum')->group(function(){
    Route::get('/products', [ApiProductController::class,'index']);
});


Route::apiResource('/products',ProductController::class);
Route::apiResource('/users',ApiUserController::class)->middleware('auth:sanctum');
Route::apiResource('/category',ApiCategoryController::class);
Route::post('/logout', [AuthController::class,'logout']);