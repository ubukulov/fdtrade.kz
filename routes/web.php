<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/cat/{id}', [IndexController::class, 'catProducts']);
Route::get('/product/{article}', [IndexController::class, 'productInfo']);
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/category/{id}/product/{productId}', [ProductController::class, 'detail'])->name('product.detail');
