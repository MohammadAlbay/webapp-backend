<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:technicain'], function () {
    Route::name('technicain.')->prefix('technicain')->group(function() {
        Route::get('/', [TechnicainViewController::class, 'index'])->name("index");
    });
});