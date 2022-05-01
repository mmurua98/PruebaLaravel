<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/* PRODUCTS */
Route::get('products/index', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('/products/create', [App\Http\Controllers\ProductController::class, 'store']);
Route::put('/products/update/{product}', [App\Http\Controllers\ProductController::class, 'update']);
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy']);

/* ORDERS (COMPRAS) */
Route::get('/orders/index', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/create', [App\Http\Controllers\OrderController::class, 'store']);

/* INVOICES (FACTURAS) */
Route::get('/invoices/index', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
Route::post('/invoices/create', [App\Http\Controllers\InvoiceController::class, 'store']);
Route::get('/invoices/show/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
