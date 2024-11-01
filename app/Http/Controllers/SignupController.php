<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\Technicain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SignupController extends Controller
{
    //
    public function index()
    {
        return view('signup', ['roles' => Role::all()]);
    }

    public function create(Request $request)
    {
        $accountType = $request->input("signup_type");
        if ($accountType == "customer") {
            return $this->createCustomer($request);
        } else if ($accountType == "technicain") {
            return $this->createTechnicain($request);
        } else if ($accountType == "employee") {
            return $this->createEmployee($request);
        }

        return redirect("/signup/");
    }

    public function addTechnicainView(Request $request)
    {
        return view('technicain.addtechnicain', [
            'specializations' => \App\Models\Specialization::where('state', 'Active')->get()
        ]);
    }

    public function addCustomerView(Request $request)
    {
        return view('customer.addcustomer', []);
    }
    private function createCustomer(Request $request)
    {
        $v = Validator::make($request->all(), [
            'signup_email' => 'required|email|unique:customers,email',
            'signup_name' => 'required|string|max:90|min:8',
            'signup_gender' => 'required',
            'signup_phone' => 'required|regex:/(218)[0-9]{9}/',
            'signup_address' => 'required',
            'signup_password' => 'required:max:32|min:6',
            'signup_birthdate' => 'required|before:1/1/2005',
        ], [
            'signup_name.required' => 'حقل الاسم مطلوب .',
            'signup_name.max' => 'حقل الاسم يجب ان يتكون من اقل من 90 حرف .',
            'signup_name.min' => 'حقل الاسم يجب ان يتكون من 8 احرف او اكتر .',
            'signup_email.required' => 'حقل البريد الاكتروني مطلوب.',
            'signup_gender.required' => 'حقل الجنس مطلوب.',
            'signup_phone.required' => 'حقل الهاتف مطلوب.',
            'signup_address.required' => 'حقل الهاتف مطلوب.',
            'signup_password.required' => 'حقل كلمة المرور مطلوب.',
            'signup_email.email' => 'حقل البريد الاكتروني يجب ان يكون عنوان بريد الكتروني صحيح.',
            'signup_phone.regex' => 'رقم الهاتف غير صحيح',
            'signup_password.min' => 'كلمة المرور يجب ان تتكون من 6 احرف وارقام على الاقل',
            'signup_birthdate.required' => 'تاريخ الميلاد مطلوب',
            'signup_birthdate.before' => 'تاريخ الميلاد لا يجب ان يكون بعد 2005',
        ]);

        if ($v->fails()) {
            return redirect("/signup/registercustomer")->withErrors($v->errors())->withInput();
        } else if ($request->input("signup_password") != $request->input("signup_password2")) {
            return redirect("/signup/registercustomer")->withErrors(['pap2notmatch' => "كلمة المرور وتأكيد كلمة المرور غير متساويين"])->withInput();
        }

        $accountType = 'customer';
        $email = $request->input("signup_email");
        $code = substr(md5(rand()), 0, 7);
        $user = Customer::create([
            "fullname"      => $request->input("signup_name"),
            "phone"       => $request->input("signup_phone"),
            "email"         => $request->input("signup_email"),
            "password"      => Hash::make($request->input("signup_password")),
            "address"       => $request->input("signup_address"),
            "gender"       => $request->input("signup_gender"),
            "birthdate" => $request->input("signup_birthdate"),
            "verification_code" => $code,
            "profile" => ($request->input("signup_gender") == 'Male' ? 'Male' : 'Female') . '.jpg'
        ]);


        $this->createUserSpace($accountType, $user);
        (new \App\Http\Controllers\Auth\VerificationController())->sendActivationEmail($request, $email, $code, $accountType);
        return redirect("/verify/")->with(['id' => $user->id, "type" => $accountType]);
    }
    private function createTechnicain(Request $request)
    {
        $v = Validator::make($request->all(), [
            'signup_email' => 'required|email|unique:technicains,email',
            'signup_name' => 'required|string|max:90|min:8',
            'signup_gender' => 'required',
            'signup_nationality' => 'required',
            'signup_phone' => 'required|regex:/(218)[0-9]{9}/',
            'signup_address' => 'required',
            'signup_password' => 'required:max:32|min:6',
            'signup_specialization' => 'required',
            'signup_birthdate' => 'required|before:1/1/2005',
        ], [
            'signup_name.required' => 'حقل الاسم مطلوب .',
            'signup_name.max' => 'حقل الاسم يجب ان يتكون من اقل من 90 حرف .',
            'signup_name.min' => 'حقل الاسم يجب ان يتكون من 8 احرف او اكتر .',
            'signup_email.required' => 'حقل البريد الاكتروني مطلوب.',
            'signup_gender.required' => 'حقل الجنس مطلوب.',
            'signup_nationality.required' => 'حقل الجنسية مطلوب.',
            'signup_phone.required' => 'حقل الهاتف مطلوب.',
            'signup_address.required' => 'حقل الهاتف مطلوب.',
            'signup_password.required' => 'حقل كلمة المرور مطلوب.',
            'signup_email.email' => 'حقل البريد الاكتروني يجب ان يكون عنوان بريد الكتروني صحيح.',
            'signup_phone.regex' => 'رقم الهاتف غير صحيح',
            'signup_password.min' => 'كلمة المرور يجب ان تتكون من 6 احرف وارقام على الاقل',
            'signup_birthdate.required' => 'تاريخ الميلاد مطلوب',
            'signup_birthdate.before' => 'تاريخ الميلاد لا يجب ان يكون بعد 2005',
        ]);
        if ($v->fails()) {
            return redirect("/signup/registertechnicain")->withErrors($v->errors())->withInput();
        } else if ($request->input("signup_password") != $request->input("signup_password2")) {
            return redirect("/signup/registertechnicain")->withErrors(['pap2notmatch' => "كلمة المرور وتأكيد كلمة المرور غير متساويين"])->withInput();
        }

        $accountType = 'technicain';
        $email = $request->input("signup_email");
        $code = substr(md5(rand()), 0, 7);
        $user = Technicain::create([
            "fullname"   => $request->input("signup_name"),
            "specialization_id"     => $request->input('signup_specialization'),
            "email"      => $email,
            "password"   => Hash::make($request->input("signup_password")),
            "address"    => $request->input("signup_address"),
            "description" => $request->input("signup_desc"),
            "profile" => ($request->input("signup_gender") == 'Male' ? 'Male' : 'Female') . '.jpg',
            "nationality" => $request->input("signup_nationality"),
            "phone"       => $request->input("signup_phone"),
            "gender"       => $request->input("signup_gender"),
            "birthdate" => $request->input("signup_birthdate"),
            "verification_code" => $code,
        ]);

        $this->createUserSpace($accountType, $user);


        (new \App\Http\Controllers\Auth\VerificationController())->sendActivationEmail($request, $email, $code, $accountType);
        return redirect("/verify/")->with(['id' => $user->id, "type" => $accountType]);
    }


    private function createEmployee(Request $request)
    {
        $v = Validator::make($request->all(), [
            'add_employee_email' => 'required|email|unique:employees,email',
        ]);
        if ($v->fails()) {
            return \App\Http\Controllers\Controller::whichReturn(
                $request,
                redirect("/signup/")->withErrors(["emailtaken" => "البريد الالكتروني مسجل مسبقا"])->withInput(),
                ['Message' => "البريد الالكتروني مسجل مسبقا", 'State' => 1]
            );
        }
        $user = Employee::create([
            "fullname"   => $request->input("add_employee_fullname"),
            "state"     => "Active",
            "email"      => $request->input("add_employee_email"),
            "password"   => Hash::make($request->input("add_employee_password")),
            "address"    => $request->input("add_employee_address"),
            "phone"    => $request->input("add_employee_phone"),
            "role_id" => $request->input("add_employee_role"),
            "profile" => ($request->input("signup_gender") == 'Male' ? 'Male' : 'Female') . '.jpg',
        ]);

        $this->createUserSpace('employee', $user);

        return \App\Http\Controllers\Controller::whichReturn(
            $request,
            redirect("/signup/"),
            ['Message' => "تم حفظ البيانات بنجاح", 'State' => 0]
        );
    }


    public function createUserSpace($accountType, $user)
    {
        //dd($accountType);
        $userdir = public_path() . "/cloud/$accountType/" . $user->id;
        Controller::deleteFolder($userdir);
        mkdir($userdir);
        mkdir($userdir . '/documents');
        mkdir($userdir . '/images');
    }
}
