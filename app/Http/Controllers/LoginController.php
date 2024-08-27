<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index() {
        return view('login');
    }

    public function login(Request $request) {

        $accountType = $request->input('login_type');
        $email = $request->input('login_emial');
        $password = $request->input('login_password');

        if(Auth::guard($accountType)->attempt(["email" => $email, "password" => $password])) {
            if($accountType == "programmer") {
                return Redirect("/programmer");
            } else {
                return Redirect("/company");
            }
        } else  { 
            return Redirect("/login")->withErrors(["status" => "Failed to login"]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return Redirect("/login");
    }

    public static function logout2() {

    }
}
