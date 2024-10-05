<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Technicain\TechnicainViewController;

Route::group(['middleware' => 'auth:technicain'], function () {
    Route::name('technicain.')->prefix('technicain')->group(function() {
        Route::get('/', [TechnicainViewController::class, 'index'])->name("index");
        Route::get('/profile', [TechnicainViewController::class, 'viewProfile'])->name('profile');
        Route::get('/mycustomers', [TechnicainViewController::class, 'viewCustomers']);

        Route::post('/edit', [TechnicainViewController::class, 'edit']);
        Route::post('/addpost', [TechnicainViewController::class, 'addPost']);

        Route::post('/set-profile', [TechnicainViewController::class, 'setProfileImage']);
        Route::post('/set-cover', [TechnicainViewController::class, 'setCoverImage']);

        Route::get('/posts', [TechnicainViewController::class, 'viewPosts']);
        Route::post('/post/addcomment', [TechnicainViewController::class, 'addComment']);
        Route::get('/post/deletecomment/{id}', [TechnicainViewController::class, 'deleteComment']);
    });
});