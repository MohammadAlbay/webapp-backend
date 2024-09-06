<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissions;
use Illuminate\Support\Facades\Validator;

class EmployeeRoleController extends Controller {
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
}