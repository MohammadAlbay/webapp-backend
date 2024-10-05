<?php

use App\Mail\Email;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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


Route::get('/hash/{pass}', function($pass) {
    return \Illuminate\Support\Facades\Hash::make($pass);
});


Route::get("/tmail", function() {
    Mail::to("mohamed.albay@laportadiroma.com")->send(new \App\Mail\VerificaionEmail("code"));
    return "Done!";
});
require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/technicain.php';
require __DIR__.'/employee.php';