<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgrammerViewController;
use App\Http\Controllers\SignupController;

Route::name('login.')->prefix('login')->group(function() {
    Route::get('/', [LoginController::class, "index"])->name("index");
    Route::post('/start', [LoginController::class, "login"])->name("start");
    Route::get('/end/{g}/', [LoginController::class, "logout"])->name("end");
});

Route::name('signup.')->prefix('signup')->group(function() {
    Route::get('/', [SignupController::class, "index"])->name("index");
    Route::post('/create', [SignupController::class, "create"])->name("create");
});

