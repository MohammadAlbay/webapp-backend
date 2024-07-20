<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index() {
        return view('login');
    }

    public function sendData(Request $request) {
        return "Your email address is : ".$request->input('login_emial');
    }
}
