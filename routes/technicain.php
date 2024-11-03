<?php

use App\Http\Controllers\ServiceReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:technicain'], function () {
    Route::name('technicain.')->prefix('technicain')->group(function() {
        Route::get('/', [TechnicainViewController::class, 'index'])->name("index");

        Route::get('/profile', [TechnicainViewController::class, 'viewProfile'])->name('profile');
        Route::get('/mycustomers', [TechnicainViewController::class, 'viewCustomers']);
        Route::get('/wallet', [TechnicainViewController::class, 'viewWallet']);
        Route::get('/subscription', [TechnicainViewController::class, 'viewSubscription']);

        Route::post('/edit', [TechnicainViewController::class, 'edit']);
        Route::post('/addpost', [TechnicainViewController::class, 'addPost']);

        Route::post('/set-profile', [TechnicainViewController::class, 'setProfileImage']);
        Route::post('/set-cover', [TechnicainViewController::class, 'setCoverImage']);

        Route::post('/topup', [TechnicainViewController::class, 'topUp']);
        Route::post('/subscripe', [TechnicainViewController::class, 'subscripe']);

        Route::get('/reservation/{state}/{id}', [TechnicainViewController::class, 'reservation']);

        Route::get('/posts', [TechnicainViewController::class, 'viewPosts']);
        Route::post('/post/addcomment', [TechnicainViewController::class, 'addComment']);
        Route::get('/post/deletecomment/{id}', [TechnicainViewController::class, 'deleteComment']);

        Route::get('/reservation-level/{id}/{state}', [TechnicainViewController::class, 'setReservationState']);
        Route::get('/scheduled-work', [TechnicainViewController::class, 'viewScheduedWork']);
        Route::get('/previouse-work', [TechnicainViewController::class, 'viewPreviouseWork']);

        Route::get('/editpost/{id}', [TechnicainViewController::class, 'editPost']);
        Route::post('/editpost/{id}', [TechnicainViewController::class, 'editPostContent']);

        Route::post('/report', [ServiceReportController::class, "reportCustomer"]);

        Route::post('/take-break', [TechnicainViewController::class, 'takeBreake']);
        Route::post('/back-to-business', [TechnicainViewController::class, 'backToBusiness']);

        
    });
});