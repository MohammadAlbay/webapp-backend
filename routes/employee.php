<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Employee\EmployeeViewController;

Route::group(['middleware' => 'auth:employee'], function () {
    Route::name('employee.')->prefix('employee')->group(function() {
        Route::get('/', [EmployeeViewController::class, 'index'])->name("index");
    });
});