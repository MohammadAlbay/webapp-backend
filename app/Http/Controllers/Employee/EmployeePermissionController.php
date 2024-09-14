<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermissions;
use Illuminate\Support\Facades\Validator;

class EmployeePermissionController extends Controller {
    public function permissionSwitchState(Request $request, $id) {
        $permission = Permission::find($id);

        if($permission == null) {
            return Controller::whichReturn($request, 
            redirect('/employee')->withErrors(['Unknown-Permission' => "لم نتمكن من العثور على الصلاحية المطلوبه"]),
            Controller::jsonMessage('لم نتمكن من العثور على الصلاحية المطلوبه', 1));
        }

        $result = ($permission->state == 'Active') ? 'Inactive' : 'Active';
        $permission->state = $result;
        $permission->save();

        RolePermissions::where('permission_id', $id)->update(['state' => $result]);

        return Controller::whichReturn($request, 
        redirect('/employee'),
        Controller::jsonMessage( 'تم حفظ التغييرات', 0));
    }
}