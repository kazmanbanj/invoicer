<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::middleware(['middleware' => 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'getAmountGroupedByCustomerAndYearMonth'])->name('home');
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class);
    Route::get('invoices/{invoice_id}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::resource('customers', App\Http\Controllers\CustomersController::class);
    Route::resource('products', App\Http\Controllers\ProductController::class);
});
