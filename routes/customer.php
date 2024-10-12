<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\CustomerViewController;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:customer'], function () {
    Route::name('customer.')->prefix('customer')->group(function () {
        Route::get('/', [CustomerViewController::class, 'index'])->name("index");
        Route::get('/showspecialists', function () {
            return "Specialists list";
        })->name("showspecialists");


        Route::post('/post/addcomment', [CustomerViewController::class, 'addComment']);
    });


    Route::get('/technicain-view/{id}', [TechnicainViewController::class, "viewProfile"]);

    Route::get('/sayhi', function () {
        return redirect("/customer/");
    });
});
