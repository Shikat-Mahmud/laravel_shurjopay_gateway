<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ShurjopayController;

Route::get('/shurjopay', [ShurjopayController::class, 'index'])->name('shurjopay.index');
Route::post('/shurjopay/pay', [ShurjopayController::class, 'pay'])->name('shurjopay.pay');
Route::get('/shurjopay/callback', [ShurjopayController::class, 'callback'])->name('shurjopay.callback');
