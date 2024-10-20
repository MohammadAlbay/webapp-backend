<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\PrepaidCard;
use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class EmployeeViewController extends Controller {
    private $guard = 'employee';
    public function index() {

        //$gen = PrepaidCard::getGenerationsDetails()[0];
        return view("employee.dashboard.index", [
            'me' => Auth::guard($this->guard)->user(),
            'specializations' => Specialization::all(),
            "roles" => Role::all(),
            "employees" => Employee::all(),
            "permissions" => Permission::all(),
            "prepaidcardGenerations" => PrepaidCard::getGenerationsDetails()
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


    public function assignRoles(Request $request) {
        $v = Validator::make($request->all(), [
            "employee_roles" => 'required', 
            "employee_name" => 'required', 
            
        ]);

        if($v->fails()) {
            return redirect("/employee/")->withErrors(["assignrole-error" => "can't create exisiting role"])->withInput();
        }
        return Redirect("/employee/");
    }


    public function addPermission(Request $request) {
        $v = Validator::make($request->all(), [
            "role" => 'required', 
            "permission" => 'required', 
        ]);
        if($v->fails()) {
            return redirect("/employee/")->withErrors(["missingdata-error" => "can't create exisiting role"])->withInput();
        }

        $role = Role::find($request->input("role"));
        
        if($role->permissions->contains("permission_id", $request->input("permission"))) {
            return redirect("/employee/")->withErrors(["existing-permission-error" => "can't create exisiting permission to role"])->withInput();
        }
        RolePermissions::create([
            "role_id" => $request->input("role"),
            "permission_id" => $request->input("permission")
        ]);

        return redirect("/employee/");
    }


    public function removePermission(Request $request, $id) {
        $rolePermission = RolePermissions::find($id);

        if($rolePermission == null) {
            return redirect("/employee/")->withErrors(["rp-error" => "can't find role permission record"]);
        }

        $rolePermission->delete();

        return redirect("/employee/");
    }


    public function switchState(Request $request, $id, $state) {
        if($state != "Active" && $state != "Inactive") {
            return Controller::whichReturn($request, 
            redirect("/employee/")->withErrors(["notfound-state-error" => "الحالة المطلوبة غير صحيحة"]),
            ['Message' => "الحالة المطلوبة غير صحيحة", 'State' => 1]);
        }

        $employee = Employee::find($id);
        if($employee == null) {
            return Controller::whichReturn($request,
            redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
            ['Message' => "لم يتم العثور على الموظف", 'State' => 1]);
        }

        $employee->state = $state;
        $employee->save();

        return Controller::whichReturn($request, 
            redirect("/employee/"),
            ['Message' => "تم حفظ التغييرات", 'State' => 0]);

    }

    public function delete(Request $request, $id) {
        $employee = Employee::find($id);
        if($employee == null) {
            return Controller::whichReturn($request,
            redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
            ['Message' => "لم يتم العثور على الموظف", 'State' => 1]);
        }

        $employee->delete();
        return Controller::whichReturn($request, 
            redirect("/employee/"),
            ['Message' => "تم حذف الموظف ", 'State' => 0]);
    }

    public function edit(Request $request) {
        $v = Validator::make($request->all(), [
            "edit_employee_fullname" => 'required', 
            "edit_employee_phone" => 'required', 
            "edit_employee_address" => 'required', 
            "edit_employee_role" => 'required', 
            "edit_employee_gender" => 'required'
        ]);
        if($v->fails()) {
            return Controller::whichReturn($request,
            redirect("/employee/")->withErrors(["data-employee-error" => "بعض المدخلات غير صحيحة"]),
            ['Message' => "بعض المدخلات غير صحيحة", 'State' => 1]);
        }

        $employee = Employee::find($request->input('employee_id'));
        if($employee == null) {
            return Controller::whichReturn($request,
            redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
            ['Message' => "لم يتم العثور على الموظف", 'State' => 1]);
        }

        $employee->fullname = $request->input('edit_employee_fullname');
        $employee->phone = $request->input('edit_employee_phone');
        $employee->address = $request->input('edit_employee_address');
        $employee->role_id = $request->input('edit_employee_role');
        $employee->gender = $request->input('edit_employee_gender');
        $employee->save();

        return Controller::whichReturn($request, 
        redirect("/employee/"),
        ['Message' => "تم حفظ التغييرات", 'State' => 0]);
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