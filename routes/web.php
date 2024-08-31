<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('index');
});



require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/technicain.php';
require __DIR__.'/employee.php';