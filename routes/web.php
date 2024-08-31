<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    $user = null;

    $guars =  [
        'customer',
        'technicain',
        'employee'
    ];

    foreach($guars as $guard) {
        if(!Auth::guard($guard)->guest()) {
            $user = $guard;
            break;
        }
    }
    return view('index', ["user" => $user]);
});



require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/technicain.php';
require __DIR__.'/employee.php';