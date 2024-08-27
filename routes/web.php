<?php

use App\Http\Controllers\CompanyViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProgrammerViewController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\ProgrammerAPI;

Route::get('/', function () {
    return view('welcome');
});

Route::name('login.')->prefix('login')->group(function() {
    Route::get('/', [LoginController::class, "index"])->name("index");
    Route::post('/start', [LoginController::class, "login"])->name("start");
    Route::get('/end', [LoginController::class, "logout"])->name("end");
});


Route::name('signup.')->prefix('signup')->group(function() {
    Route::get('/', [SignupController::class, "index"])->name("index");
    Route::post('/create', [SignupController::class, "create"])->name("create");
});

Route::name('programmer.')->prefix('programmer')->group(function() {
    Route::get('/', [ProgrammerViewController::class, "index"])->name("index");
});

Route::name('company.')->prefix('company')->group(function() {
    Route::get('/', [CompanyViewController::class, "index"])->name("index");
});


Route::name("api_programmer")->prefix("api_programmer")->group(function() {
    // CRUD
    Route::get("/", [ProgrammerAPI::class, "index"])->name("index");
    Route::get("/{id}/", [ProgrammerAPI::class, "index"])->name("index");
    Route::put("/{id}/{name}/", [ProgrammerAPI::class, "update"])->name("update");
    Route::post("/", [ProgrammerAPI::class, "store"])->name("store");
    Route::delete("/{id}/", [ProgrammerAPI::class, "destroy"])->name("destroy");
});






























Route::group(['middleware' => 'auth:programmer'], function () {
    // Routes for programmers
});

Route::group(['middleware' => 'auth:company'], function () {
    // Routes for companies
});
