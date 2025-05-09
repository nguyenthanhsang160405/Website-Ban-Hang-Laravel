<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::get('products',[ProductController::class,'index'])->name('products');
Route::get('product/{name}/{id}',[ProductController::class,'getIdPro'])->where(['name'=>'[a-zA-Z0-9]+','id'=>'[0-9]+']); 
Route::get('product',[ProductController::class,'showProduct']);
Route::get('post',[PostController::class,'index']);
Route::get('posts',[PostController::class,'rangePost']);
Route::get('posts/insert',[PostController::class,'insert']);
Route::get('post/update/{id}',[PostController::class,'updatekhac']);
Route::get('post/delete/{id}',[PostController::class,'deletekhac']);
Route::get('/foods',[FoodController::class,'getAllFood']);
Route::get('/food/add_food',[FoodController::class,'pageAddFood']);
Route::post('/food/actionAddFood',[FoodController::class,'addFood2']);

Route::get('/showpro/{product}',[ProductsController::class,'show']);
// Route::resource('/food/actionAddFood',FoodController::class);
// Route::get('/', function () {
//     // return view('welcome');
//     return env('MY_NAME');
// });
// Route::get('/profile/', function () {
//     // return view('welcome');addFood
//     return view('profile');
// });
// Route::get('/food/', function () {
//     // return view('welcome');
//     return redirect('/api_food/');

// });
// Route::get('/api_food/', function () {
//     // return view('welcome');
//     return response()->json([
//         'food' => 'pizza',
//         'drink' => 'coke'
//     ]);

// });
