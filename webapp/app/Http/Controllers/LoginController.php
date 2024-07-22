<?php

namespace App\Http\Controllers;

use App\Models\Programmer;
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

        $user = null;
        if($accountType == "programmer") {
            $programmer = Programmer::where;
            
        } else if($accountType == "company") {
//company
        }

        //auth($accountType)->login($programmer);
        $p = Programmer::find(0);
        auth("programmer")->login($p);
        return "Your email address is : ".$request->input('login_emial');
    }

    public function logout(Request $request) {
        Auth::logout();
    }
}
