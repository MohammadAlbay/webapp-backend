<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class EmployeeViewController extends Controller {
    private $guard = 'employee';
    public function index() {
        return view("employee.index", [
            'me' => Auth::guard($this->guard)->user(),
            'specializations' => Specialization::all(),
            "roles" => Role::all()
        ]);
    }

    public function addSpecialization(Request $request) {
        $name = $request->input('spec_name');
        
        $v = Validator::make($request->all(),[
            'spec_name' => 'required|unique:specializations,name',
        ]);
        if($v->fails()) {
            return redirect("/employee/")->withErrors(["specialization-exists" => "can't create exisiting specialization"])->withInput();
        }

        Specialization::create([
           "name" => $name
        ]);

        return redirect('/employee/')->with(['done' => "Saved!"]);
    }
    public function setSpecializationState(Request $request, $id, $state) {
        $spec = Specialization::find($id);
        
        if($spec == null) {
            return Redirect("/employee/")->withErrors(["missing-specialization" => "Unable to locate the targeting specialization"]);
        } 
        else {
            $spec->state = $state; //$spec->state == "Active" ? "Inactive" : "Active";
            $spec->save();
            return Redirect("/employee/");
        }
    }

    public function addRole(Request $request) {
        $name = $request->input('role_name');
        
        $v = Validator::make($request->all(),[
            'role_name' => 'required|unique:roles,name',
        ]);
        if($v->fails()) {
            return redirect("/employee/")->withErrors(["role-exists" => "can't create exisiting role"])->withInput();
        }

        Role::create([
           "name" => $name
        ]);

        return redirect('/employee/')->with(['done' => "Saved!"]);
    }













    public function loginview(Request $request) {
        return view('employee.loginview');
    }
    public function login(Request $request) {
        $credentials  = [
            "email" => $request->input('login_emial'), 
            "password" => $request->input('login_password')
        ];

        if(Auth::guard($this->guard)->attempt($credentials, true)) {
            $request->session()->regenerate();
            return Redirect("/employee/");
        } else {
            return Redirect("/login/employee/")->withErrors(["status" => "Unauthorized access. employees only allowed."]);
        }


    }
    public function logout(Request $request) {
        $request->session()->invalidate();
        Auth::guard($this->guard)->logout();
        return Redirect("/");
    }
}