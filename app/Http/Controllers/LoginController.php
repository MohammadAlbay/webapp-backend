<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Technicain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public static $consumerGuards = ['customer', 'technicain'];
    // login.index > /login/
    public function index()
    {
        if (auth('customer')->check())
            return Redirect()->route('customer.index');
        else if (auth('technicain')->check())
            return Redirect()->route('technicain.index');
        else
            return view('login');
    }


    // login.start > /login/start/
    public function login(Request $request)
    {
        $rememberMe = $request->input('login_rememberme') == 'on';
        $credentials  = [
            "email" => $request->input('login_emial'),
            "password" => $request->input('login_password')
        ];

        $hashedPassword = Hash::make($credentials['password']);
        $loggedIn = false;
        $quard = null;
        foreach (LoginController::$consumerGuards as $g) {
            if ($g == 'customer') {
                $tempUser = Customer::where('email', $credentials['email'])
                            ->first();
            } else if ($g == 'technicain') {
                $tempUser = Technicain::where('email', $credentials['email'])
                            ->first();
            }

            if ($tempUser != null) {
                //Log::info("Account act. date : '".$tempUser->email_verified_at."'");
                if ($tempUser->email_verified_at == null || $tempUser->email_verified_at == '') {
                    return redirect()->back()->withErrors(['activate-account-first' =>'قم بتفعيل حسابك اولا']);
                } else if($tempUser->state == "Bloced") {
                    return redirect()->back()->withErrors(['blocked-account' =>'لقد تم تقييد الوصول الى حسابك']);
                }
            }

            if (Auth::guard($g)->attempt($credentials, $rememberMe)) {
                $request->session()->regenerate();
                $loggedIn = true;
                $quard = $g;
                break;
            }
        }
        if ($loggedIn) {
            switch ($quard) {
                case "customer":
                    return Redirect("/customer/");
                case "technicain":
                    return Redirect("/technicain/");
                default:
                    return Redirect("/");
            }
        } else {
            return Redirect("/login")->withErrors(["status" => "Failed to login"]);
        }
    }

    public function logout(Request $request, $g)
    {
        Auth::guard($g)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect("/login");
    }
}
