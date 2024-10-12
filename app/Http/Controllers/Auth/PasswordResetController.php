<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Technicain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // public function index()
    // {
    //     return view('auth.password-reset_view');
    // }

    public function makeResetRequestEmail(Request $request)
    {
        $email = $request->input('email'); // value from the form data
        $user_type = EmailUtility::getEmailOwner($email); // returns customer, techincain, employee or null if not recognized

        // check if we couldn't recognize the user type (not customer, not technicain)
        if ($user_type == null) return Controller::whichReturn(
            $request,
            redirect('/'),
            Controller::jsonMessage('البريد الالكتروني غير صحيح', 1)
        );

        // send email
        $this->sentEmail($email, $user_type);
        // return to user (Result)
        return Controller::whichReturn(
            $request,
            redirect()->back()->with('reset-request-made', 'done'),
            Controller::jsonMessage('قم بالتقق من بريدك اللاكتروني ', 0)
        );
    }

    ///
    /// - combine the link with the :
    ///   base64 encoded strings of :
    ///   email, user type and a datetiem(6 hours ahead)
    /// - send an email to the user
    private function sentEmail($email, $type)
    {
        $url = request()->getSchemeAndHttpHost();
        $now = Carbon::now();
        $sixHoursLater = $now->addHours(6);
        $base64EncodedDate = base64_encode($sixHoursLater->toJSON());
        $message = $url . '/reset-request/' . \base64_encode($email) . '/' . \base64_encode($type) . '/' . $base64EncodedDate;
        Mail::to($email)->send(new \App\Mail\ResetPasswordEmail($message));
    }


    public function verifyRequestAndShowView(Request $request, $email, $type, $cabon_time)
    {
        $type = base64_decode($type);
        $email = base64_decode($email);
        $cabon_time = base64_decode($cabon_time); // from base 64 to JSON string
        //return;
        // convert from JSON string to carbon object
        $linkDate = Carbon::parse($cabon_time); //json_decode($cabon_time, true)['date']
        $now = Carbon::now();

        if($linkDate->lessThan($now)) {
            return view('auth.password-reset_view')->with('invalid-request-link', true);
        } else {
            if($type == 'customer')
                $user = Customer::where('email', $email)->first();
            else if($type == 'technicain')
                $user = Technicain::where('email', $email)->first();
            else if($type == 'employee')
                $user = Employee::where('email', $email)->first();    
            else
                $user = null;

            if($user == null) return redirect('/');
            else
                return view('auth.password-reset_view', ['user' => $user, 'type' => $type]);
        }
        
    }

    public function setNewPassword(Request $request) {
        $password1 = $request->input('reset_from_password');
        $password2 = $request->input('reset_from_password2');
        $type = $request->input(key: '_type');
        $id = $request->input(key: '_id');

        $v = Validator::make($request->all(), [
            'reset_from_password' => 'required:max:32|min:6',
            'reset_from_password2' => 'required:max:32|min:6',
        ], [
            'reset_from_password.min' => 'كلمة المرور يجب ان تتكون من 6 احرف وارقام على الاقل',
            'reset_from_password2.min' => 'تأكيد كلمة المرور يجب ان تتكون من 6 احرف وارقام على الاقل',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        if($password1 != $password2)
            return redirect()->back()
            ->withErrors(['incorrect-passwords' => 'كلمت المرور غير متطابقة']);

        if($type == 'customer')
            $user = Customer::find($id);
        else if($type == 'technicain')
            $user = Technicain::find($id);
        else if($type == 'employee')
            $user = Employee::find($id);
        else
            $user = null;

        if($user == null)
            return redirect()->back()
            ->withErrors(['unknwon-account-type' => 'لم يتم التعرف على بيانات الطلب']);

        $user->password = Hash::make($password1);
        $user->save();

        return redirect('/login')->with('password-reset-done', true);
    }
}
