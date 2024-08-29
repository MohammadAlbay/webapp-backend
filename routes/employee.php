<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::group(['middleware' => 'auth:employee'], function () {
    Route::name('employee.')->prefix('employee')->group(function() {
        Route::get('/', function () {return "Employee UI";})->name("index");
    });
});