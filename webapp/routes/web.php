<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::name('login.')->prefix('login')->group(function() {
    Route::get('/', [LoginController::class, "index"])->name("index");
    Route::post('/start', [LoginController::class, "login"])->name("start");
    Route::post('/end', [LoginController::class, "logout"])->name("end");
});

/*
    Get
    Post
    Put
    Delete
*/