<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Technicain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class VerificationController extends Controller
{
    public function verifyEmail($email, $secret, $user_type = null)
    {
        $email = \base64_decode($email); 
        $secret = \base64_decode($secret);
        $user_type = $user_type ? \base64_decode($user_type) : null;

        if($user_type == null) return;

        if ($user_type == "technicain") {
            $user = Technicain::where('email', $email)->where('verification_code', $secret)->first();
        } else if($user_type == "customer"){ // use default user (customer)
            $user = Customer::where('email', $email)->where('verification_code', $secret)->first();
        } else {
            return redirect('/');
        }

        if ($user) { 
            $user->email_verified_at = now();
            $user->save();

            RateLimiter::clear('send-message:'.$user->id);

            return \redirect('/login')->with('account-verified', 'done');
        } else { 
            return \redirect('/');
        }
    }


    public function showVerifyView(Request $request) {
        return view('auth.verify_view');
    }
    public function sendActivationEmail(Request $request, $email, $code, $type)
    {
        $url = request()->getSchemeAndHttpHost();
        $message = $url.'/verify/' . \base64_encode($email) . '/' . \base64_encode($code).'/'.\base64_encode($type);
        Mail::to($email)->send(new \App\Mail\VerificaionEmail($message));
    }


    public function resendVerificationCode(Request $request, $id, $user_type) {

        if($user_type == "technicain")
            $user = Technicain::find($id);
        else if($user_type == "customer")
            $user = Customer::find($id);
        else 
            $user = null;
        
        if($user == null) {
            return redirect('/verify/')->withErrors(['verify-formate-error' => 'uknown request formate']);
        }



        if (RateLimiter::tooManyAttempts('send-verify-code:'.$id, 5)) {
            return redirect('/verify/')->withErrors(['verify-limit-error' => 'too many requests']);
        } else {
            $this->sendActivationEmail($request, $user->email, $user->verification_code, $user_type);
            RateLimiter::increment('send-verify-code:'.$id);
            return redirect("/verify/")->with(['id' => $user->id, "type" =>$user_type]);
        }

        
    }
}
