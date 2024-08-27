<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Programmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    //
    public function index() {
        return view('signup');
    }

    public function create(Request $request) {

        $accountType = $request->input("signup_type");

        if($accountType == "programmer") {
            Programmer::create([    
                "fullname"      => $request->input("signup_name"),
                "subname"       => $request->input("signup_name"),
                "qualification" => $request->input("signup_qualification"),
                "email"         => $request->input("signup_email"),
                "password"      => Hash::make($request->input("signup_password")),
                "address"       => "",
                "studied_at"    => $request->input("signup_studiedat")
            ]);
        } else {
            Company::create([   
                "fullname"   => $request->input("signup_name"),
                "subname"    => $request->input("signup_name"),
                "status"     => "PENDING",
                "email"      => $request->input("signup_email"),
                "password"   => Hash::make($request->input("signup_password")),
                "address"    => "",
                "description" => ""
            ]);
        }

        return redirect("/signup/");
    }

}
