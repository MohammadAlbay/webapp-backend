<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public static $consumerGuards = ['customer', 'technicain'];
    // login.index > /login/
    public function index() {
        return view('login');
    }


    // login.start > /login/start/
    public function login(Request $request) {

        $credentials  = [
            "email" => $request->input('login_emial'), 
            "password" => $request->input('login_password')
        ];

        $loggedIn = false;
        $quard = null;
        foreach(LoginController::$consumerGuards as $g) {
            if(Auth::guard($g)->attempt($credentials, true)) {
                $request->session()->regenerate();
                /* إنشاء معرف جلسة جديد للمستخدم، مما يعني أن أي جلسة قديمة كانت موجودة لن تكون صالحة بعد الآن.  */
                $loggedIn = true;
                $quard = $g;
                break;
            }
        }
        if($loggedIn) {
            switch($quard) {
                case "customer": return Redirect("/customer/");
                case "technicain": return Redirect("/technicain/");
                default: return Redirect("/");
            }
        } else { 
            return Redirect("/login")->withErrors(["status" => "Failed to login"]);
        }
    }

    public function logout(Request $request, $g) {
        // Auth::logout();
        Auth::guard($g)->logout();
        return Redirect("/login");
    }
}
