<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgrammerViewController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\Employee\EmployeeViewController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::name('login.')->prefix('login')->group(function () {
    Route::get('/', [LoginController::class, "index"])->name("index");
    Route::post('/start', [LoginController::class, "login"])->name("start");
    Route::get('/end/{g}/', [LoginController::class, "logout"])->name("end");

    // Employee auth route
    Route::get('/employee/', [EmployeeViewController::class, 'loginview'])->name('loginview');
    Route::post('/employee/start/', [EmployeeViewController::class, 'login'])->name('employee.start');
    Route::get('/employee/end/', [EmployeeViewController::class, 'logout'])->name('employee.logout');
});

Route::name('signup.')->prefix('signup')->group(function () {
    Route::get('/', [SignupController::class, "index"])->name("index");
    Route::get('/registertechnicain', [SignupController::class, "addTechnicainView"])->name("registertechnicain_view");
    Route::get('/registercustomer', [SignupController::class, "addCustomerView"])->name("registercustomer_view");
    Route::post('/create', [SignupController::class, "create"])->name("create");
});
