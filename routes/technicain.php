<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'auth:technicain'], function () {
    Route::name('technicain.')->prefix('technicain')->group(function() {
        Route::get('/', function () {return "Technicain UI";})->name("index");
    });
});