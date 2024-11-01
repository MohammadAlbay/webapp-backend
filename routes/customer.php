<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Customer\CustomerViewController;
use App\Http\Controllers\ServiceReportController;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:customer'], function () {
    Route::name('customer.')->prefix('customer')->group(function() {
        Route::get('/', [CustomerViewController::class, 'index'])->name("index");
        Route::get('/showspecialists', function() {return "Specialists list";})->name("showspecialists");

        Route::post('/search', [CustomerViewController::class, 'search']);
        Route::post('/addreservation/{id}', [CustomerViewController::class, 'addReservation']);


        Route::post('/topop', [CustomerViewController::class, 'topUp']);

        Route::post('/post/addcomment', [CustomerViewController::class, 'addComment']);
        Route::post('/set-profile', action: [CustomerViewController::class, 'setProfileImage']);
        Route::post('/edit', [CustomerViewController::class, 'edit']);

        Route::get('/myreservations', [CustomerViewController::class, 'myReservation']);
        Route::get('/reservation/cancel/{id}', [CustomerViewController::class, 'cancelReservation']);
        Route::get('/technicain-view/{id}',[TechnicainViewController::class, "viewProfile"]);

        Route::get('/editview', [CustomerViewController::class, 'editView']);
        Route::get('/mywallet', [CustomerViewController::class, 'myWallet']);

        Route::post('/rate/{id}/{stars}', [CustomerViewController::class, 'rateTechnicain']);

        Route::post('/report', [ServiceReportController::class, "reportTechnicain"]);
    });

    
});

