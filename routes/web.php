<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', function () {
    return view('form');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('products', App\Http\Controllers\ProductController::class);
Route::post('/products/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::resource('account', App\Http\Controllers\UserController::class);
Route::put('/account/change-password/{id}', [App\Http\Controllers\UserController::class, 'updatePassword']);
Route::resource('sales', App\Http\Controllers\SaleController::class);
