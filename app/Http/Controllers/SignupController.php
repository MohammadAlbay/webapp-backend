<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Specialization;
use App\Models\Technicain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    //
    public function index() {
        return view('signup', ['specializations' => Specialization::where("state", "Active")->get()]);
    }

    public function create(Request $request) {
        $accountType = $request->input("signup_type");

        if($accountType == "customer") {
            $this->createCustomer($request);
        } else if($accountType == "technicain") {
            $this->createTechnicain($request);
        } else if($accountType == "employee") {
            $this->createEmployee($request);
        }

        return redirect("/signup/");
    }

    private function createCustomer(Request $request) {
        $v = Validator::make($request->all(),[
            'signup_email' => 'required|email|unique:customers,email',
        ]);
        if($v->fails()) {
            //dd($v->errors());
            return redirect("/signup/")->withErrors(["emailtaken" => "email already taken"])->withInput();
        }
        Customer::create([    
            "fullname"      => $request->input("signup_name"),
            "phone"       => "0919885206",
            "email"         => $request->input("signup_email"),
            "password"      => Hash::make($request->input("signup_password")),
            "address"       => "",
            "gender"       => "Male",
        ]);
    }
    private function createTechnicain(Request $request) {
        $v = Validator::make($request->all(),[
            'signup_email' => 'required|email|unique:technicains,email',
        ]);
        if($v->fails()) {
            //dd($v->errors());
            return redirect("/signup/")->withErrors(["emailtaken" => "email already taken"])->withInput();
        }
        Technicain::create([   
            "fullname"   => $request->input("signup_name"),
            "specialization_id"     => $request->input('signup_specialization'),
            "email"      => $request->input("signup_email"),
            "password"   => Hash::make($request->input("signup_password")),
            "address"    => "",
            "description" => "",
            "profile" => "",
            "nationality" => "",
            "phone"       => "0919885",
        ]);
    }
    private function createEmployee(Request $request) {
        $v = Validator::make($request->all(),[
            'signup_email' => 'required|email|unique:employees,email',
        ]);
        if($v->fails()) {
            return redirect("/signup/")->withErrors(["emailtaken" => "email already taken"])->withInput();
        }
        Employee::create([   
            "fullname"   => $request->input("signup_name"),
            "state"     => "Active",
            "email"      => $request->input("signup_email"),
            "password"   => Hash::make($request->input("signup_password")),
            "address"    => "",
            "phone"    => ""
        ]);
    }
}