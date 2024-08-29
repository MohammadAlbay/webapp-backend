<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\CustomerViewController;

Route::group(['middleware' => 'auth:customer'], function () {
    Route::name('customer.')->prefix('customer')->group(function() {
        Route::get('/', [CustomerViewController::class, 'index'])->name("index");
    });
});