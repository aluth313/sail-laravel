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
    return redirect('/home');
});

Route::get('/form', function () {
    return view('form');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::resource('customers', App\Http\Controllers\CustomerController::class);
    Route::get('/customers/history/{id}', [App\Http\Controllers\CustomerController::class, 'history']);
    Route::get('/customers/detail-history/{id}/', [App\Http\Controllers\CustomerController::class, 'detailHistory']);
    Route::post('/products/search', [App\Http\Controllers\ProductController::class, 'search']);
    Route::get('/products/add-stock/{id}', [App\Http\Controllers\ProductController::class, 'addStock']);
    Route::put('/products/add-stock/{id}', [App\Http\Controllers\ProductController::class, 'updateStock']);
    Route::resource('account', App\Http\Controllers\UserController::class);
    Route::put('/account/change-password/{id}', [App\Http\Controllers\UserController::class, 'updatePassword']);
    Route::resource('sales', App\Http\Controllers\SaleController::class);
    Route::get('/report-per-month', [App\Http\Controllers\SaleController::class, 'perMonth']);
    Route::get('/report-per-day', [App\Http\Controllers\SaleController::class, 'perDay']);
    Route::post('/report-per-month', [App\Http\Controllers\SaleController::class, 'getDataPerMonth']);
    Route::post('/report-per-day', [App\Http\Controllers\SaleController::class, 'getDataPerDay']);
    Route::post('/print-struk', [App\Http\Controllers\SaleController::class, 'printStruk']);
    Route::resource('histories', App\Http\Controllers\HistoryController::class);
});
