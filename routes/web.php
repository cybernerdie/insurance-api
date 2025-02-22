<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Quotation\ViewQuotationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', RegisterController::class)->name('register');
Route::get('/login', LoginController::class)->name('login');
Route::get('/quotation', ViewQuotationController::class)->name('quotation');