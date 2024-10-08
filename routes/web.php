<?php

use App\Mail\Email;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    

    // Redirecting to Rahma's UI :)
    return redirect('/homepage');
});


Route::get('/hash/{pass}', function($pass) {
    return \Illuminate\Support\Facades\Hash::make($pass);
});


// rahma was here 
// i add route just to see my page 
Route::get('/homepage', [HomeController::class, 'index']);

Route::get('/specializations', [SpecializationController::class, 'index'])->name('specializations.index');
Route::get('/specializations/{id}/technicians', [SpecializationController::class, 'showTechnicians'])->name('specializations.technicians');

require __DIR__.'/auth.php';
require __DIR__.'/customer.php';
require __DIR__.'/technicain.php';
require __DIR__.'/employee.php';