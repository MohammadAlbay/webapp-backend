<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\CustomerViewController;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:customer'], function () {
    Route::name('customer.')->prefix('customer')->group(function() {
        Route::get('/', [CustomerViewController::class, 'index'])->name("index");
        Route::get('/showspecialists', function() {return "Specialists list";})->name("showspecialists");

        Route::post('/search', [CustomerViewController::class, 'search']);
        Route::post('/addreservation/{id}', [CustomerViewController::class, 'addReservation']);

        Route::post('/post/addcomment', [CustomerViewController::class, 'addComment']);

        Route::get('/myreservations', [CustomerViewController::class, 'myReservation']);
        Route::get('/technicain-view/{id}',[TechnicainViewController::class, "viewProfile"]);
    });

    


    Route::get('/sayhi', function() {
        return redirect("/customer/");
    });
});

