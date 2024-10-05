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
            return Controller::whichReturn($request, redirect("/employee/")
                        ->withErrors(["role-exists" => "لا يمكن ان يتكرر المسمى الوظيفي"])->withInput(),
                Controller::jsonMessage("لا يمكن ان يتكرر المسمى الوظيفي", 1)
            );
        }

        $role = Role::create([
           "name" => $name
        ]);

        return Controller::whichReturn($request, redirect("/employee/"),
                Controller::jsonMessage($role, 0)
        );
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
        ]);
        $permissionID = $request->input('permisison_'.$request->input('role'));
        if($v->fails() || $permissionID == null) {
            return Controller::whichReturn($request,
            redirect("/employee")->withErrors(["missingdata-error" => "بعض البيانات غير موجودة في الطلب"]),
            Controller::jsonMessage('بعض البيانات غير موجودة في الطلب', 1));
        }

        $role = Role::find($request->input("role"));
        
        if($role == null) {
            return  Controller::whichReturn($request, 
                redirect('/employee')->withErrors(['missingrole-notallowed' => "المسمى الوظيفي غير موجود"]),
                Controller::jsonMessage('المسمى الوظيفي غير موجود', 1));
        }

        if(Permission::find($permissionID) == null) {
            return  Controller::whichReturn($request, 
                redirect('/employee')->withErrors(['missingpermission-notallowed' => "الصلاحية المطلوبة غير موجودة"]),
                Controller::jsonMessage('الصلاحية المطلوبة غير موجودة', 1));
        }

        if($role->permissions->contains("permission_id", $permissionID)) {
            return  Controller::whichReturn($request, 
                redirect('/employee')->withErrors(['duplicate-notallowed' => "الصلاحية موجودة بالفعل"]),
                Controller::jsonMessage('الصلاحية موجودة بالفعل', 1));
        }
        
        RolePermissions::create([
            "role_id" => $role->id,
            "permission_id" => $permissionID
        ]);

        return Controller::whichReturn($request, 
        redirect('/employee'),
        Controller::jsonMessage( 'تم حفظ التغييرات', 0));
    }


    public function removePermission(Request $request, $id) {
        $rolePermission = RolePermissions::find($id);

        if($rolePermission == null) {
            return Controller::whichReturn($request, 
        redirect('/employee')->withErrors(['Unknown-RPermission' => 'لم نتمكن من العثور على الصلاحية المطلوب حذفها']),
        Controller::jsonMessage( 'لم نتمكن من العثور على الصلاحية المطلوب حذفها', 1));
        }

        $rolePermission->delete();

        return Controller::whichReturn($request, 
        redirect('/employee'),
        Controller::jsonMessage( 'تم حفظ التغييرات', 0));
    }

    public function switchRolePermission(Request $request, $id) {
        $rolePermission = RolePermissions::find($id);

        if($rolePermission == null) {
            return Controller::whichReturn($request, 
            redirect('/employee')->withErrors(['Unknown-Permission' => "لم نتمكن من العثور على الصلاحية المطلوبه"]),
            Controller::jsonMessage('لم نتمكن من العثور على الصلاحية المطلوبه', 1));
        }

        $result = ($rolePermission->state == 'Active') ? 'Inactive' : 'Active';
        $rolePermission->state = $result;
        $rolePermission->save();

        return Controller::whichReturn($request, 
        redirect('/employee'),
        Controller::jsonMessage( 'تم حفظ التغييرات', 0));
    }
}