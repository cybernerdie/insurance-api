<?php

use App\Http\Controllers\Api\Auth as AuthControllers;
use App\Http\Controllers\Api\Quotation\GetQuotationController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', AuthControllers\RegisterController::class)->name('register');
    Route::post('login', AuthControllers\LoginController::class)->name('login');
    Route::post('logout', AuthControllers\LogoutController::class)->name('logout')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', AuthControllers\GetUserController::class)->name('user.index');

    Route::prefix('quotation')->group(function () {
        Route::post('/', GetQuotationController::class)->name('quotation.index');
    });
});