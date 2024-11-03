<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\PrepaidCard;
use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\Specialization;
use App\Models\Technicain;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class EmployeeViewController extends Controller
{
    private $guard = 'employee';
    public function index()
    {

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

    public function addSpecialization(Request $request)
    {
        $name = $request->input('spec_name');

        $v = Validator::make($request->all(), [
            'spec_name' => 'required|unique:specializations,name',
        ]);
        if ($v->fails()) {
            return redirect("/employee/")->withErrors(["specialization-exists" => "can't create exisiting specialization"])->withInput();
        }

        Specialization::create([
            "name" => $name
        ]);

        return redirect('/employee/')->with(['done' => "Saved!"]);
    }
    public function setSpecializationState(Request $request, $id, $state)
    {
        $spec = Specialization::find($id);

        if ($spec == null) {
            return Redirect("/employee/")->withErrors(["missing-specialization" => "Unable to locate the targeting specialization"]);
        } else {
            $spec->state = $state; //$spec->state == "Active" ? "Inactive" : "Active";
            $spec->save();
            return Redirect("/employee/");
        }
    }

    public function addRole(Request $request)
    {
        $name = $request->input('role_name');

        $v = Validator::make($request->all(), [
            'role_name' => 'required|unique:roles,name',
        ]);
        if ($v->fails()) {
            return redirect("/employee/")->withErrors(["role-exists" => "can't create exisiting role"])->withInput();
        }

        Role::create([
            "name" => $name
        ]);

        return redirect('/employee/')->with(['done' => "Saved!"]);
    }


    public function assignRoles(Request $request)
    {
        $v = Validator::make($request->all(), [
            "employee_roles" => 'required',
            "employee_name" => 'required',

        ]);

        if ($v->fails()) {
            return redirect("/employee/")->withErrors(["assignrole-error" => "can't create exisiting role"])->withInput();
        }
        return Redirect("/employee/");
    }


    public function addPermission(Request $request)
    {
        $v = Validator::make($request->all(), [
            "role" => 'required',
            "permission" => 'required',
        ]);
        if ($v->fails()) {
            return redirect("/employee/")->withErrors(["missingdata-error" => "can't create exisiting role"])->withInput();
        }

        $role = Role::find($request->input("role"));

        if ($role->permissions->contains("permission_id", $request->input("permission"))) {
            return redirect("/employee/")->withErrors(["existing-permission-error" => "can't create exisiting permission to role"])->withInput();
        }
        RolePermissions::create([
            "role_id" => $request->input("role"),
            "permission_id" => $request->input("permission")
        ]);

        return redirect("/employee/");
    }


    public function removePermission(Request $request, $id)
    {
        $rolePermission = RolePermissions::find($id);

        if ($rolePermission == null) {
            return redirect("/employee/")->withErrors(["rp-error" => "can't find role permission record"]);
        }

        $rolePermission->delete();

        return redirect("/employee/");
    }


    public function switchState(Request $request, $id, $state)
    {
        if ($state != "Active" && $state != "Inactive") {
            return Controller::whichReturn(
                $request,
                redirect("/employee/")->withErrors(["notfound-state-error" => "الحالة المطلوبة غير صحيحة"]),
                ['Message' => "الحالة المطلوبة غير صحيحة", 'State' => 1]
            );
        }

        $employee = Employee::find($id);
        if ($employee == null) {
            return Controller::whichReturn(
                $request,
                redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
                ['Message' => "لم يتم العثور على الموظف", 'State' => 1]
            );
        }

        $employee->state = $state;
        $employee->save();

        return Controller::whichReturn(
            $request,
            redirect("/employee/"),
            ['Message' => "تم حفظ التغييرات", 'State' => 0]
        );
    }

    public function delete(Request $request, $id)
    {
        $employee = Employee::find($id);
        if ($employee == null) {
            return Controller::whichReturn(
                $request,
                redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
                ['Message' => "لم يتم العثور على الموظف", 'State' => 1]
            );
        }

        $employee->delete();
        return Controller::whichReturn(
            $request,
            redirect("/employee/"),
            ['Message' => "تم حذف الموظف ", 'State' => 0]
        );
    }


    public function edit(Request $request)
    {
        $v = Validator::make($request->all(), [
            'edit_employee_fullname' => 'required|string|max:90|min:8',
            'edit_employee_address' => 'required',
            'edit_employee_phone' => 'required|regex:/(218)[0-9]{9}/',
            'edit_employee_role' => 'required',
            'edit_employee_gender' => 'required'
        ], [
            'edit_employee_fullname.required' => 'حقل الاسم مطلوب .',
            'edit_employee_fullname.max' => 'حقل الاسم يجب ان يتكون من اقل من 90 حرف .',
            'edit_employee_fullname.min' => 'حقل الاسم يجب ان يتكون من 8 احرف او اكتر .',
            'edit_employee_gender.required' => 'حقل الجنس مطلوب.',
            'edit_employee_phone.required' => 'حقل الهاتف مطلوب.',
            'edit_employee_address.required' => 'حقل العنوان مطلوب.',
            'edit_employee_phone.regex' => 'رقم الهاتف غير صحيح',
            'edit_employee_role.required' => 'المسمى الوظيفي مطلوب'
        ]);
        if ($v->fails()) {
            $err = $v->errors();
            return Controller::whichReturn(
                $request,
                redirect("/signup/employee/")->withErrors(["emailtaken" => "البريد الالكتروني مسجل مسبقا"])->withInput(),
                Controller::jsonMessage($err->first($err->keys()[0]), 1)
            );
        }

        $wantToIgnorePassword = false;
        if ($request->has('edit_employee_password')) {
            $password = $request->input('edit_employee_password');

            if (empty($password)) {
                $wantToIgnorePassword = true;
            } else {
                $rules = [
                    'edit_employee_password' =>  'required:max:32|min:6'
                ];
                $messages = [
                    'edit_employee_password.required' => 'حقل كلمة المرور مطلوب.',
                    'edit_employee_password.min' => 'كلمة المرور يجب ان تتكون من 6 احرف وارقام على الاقل',
                ];

                // Create a validator instance
                $validator = Validator::make(['edit_employee_password' => $password], $rules, $messages);

                if ($validator->fails()) {
                    $err = $validator->errors();
                    return Controller::whichReturn(
                        $request,
                        redirect("/signup/employee/")->withErrors(["emailtaken" => "البريد الالكتروني مسجل مسبقا"])->withInput(),
                        Controller::jsonMessage($err->first($err->keys()[0]), 1)
                    );
                }
            }
        }

        $roleID = (int)$request->input("edit_employee_role");
        if ($roleID == 8) {
            return Controller::whichReturn(
                $request,
                redirect("/signup/employee/")->withErrors(["emailtaken" => "البريد الالكتروني مسجل مسبقا"])->withInput(),
                Controller::jsonMessage("لا يمكن استخدام هذا المسمى الوظيفي ", 1)
            );
        }

        $employee = Employee::find($request->input('employee_id'));
        if ($employee == null) {
            return Controller::whichReturn(
                $request,
                redirect("/employee/")->withErrors(["notfound-employee-error" => "لم يتم العثور على الموظف"]),
                ['Message' => "لم يتم العثور على الموظف", 'State' => 1]
            );
        }

        $employee->fullname = $request->input('edit_employee_fullname');
        $employee->phone = $request->input('edit_employee_phone');
        $employee->address = $request->input('edit_employee_address');
        $employee->role_id = $request->input('edit_employee_role');
        $employee->gender = $request->input('edit_employee_gender');
        if ($request->has('edit_employee_password') && !$wantToIgnorePassword) {
            $employee->password = Hash::make($request->input('edit_employee_password'));
        }
        $employee->save();

        return Controller::whichReturn(
            $request,
            redirect("/employee/"),
            Controller::jsonMessage("تم حفظ التغييرات", 0)
        );
    }



    public function searchForCustomers(Request $request)
    {
        $search = $request->input('search');

        if ($search == "") return "";

        $customers = Customer::where('fullname', 'LIKE', "%$search%")->get();
        $me = Auth::guard('employee')->user();
        return view('employee.dashboard.customer-searchview', compact('customers', 'me'))->render();
    }
    public function searchForTechnicains(Request $request)
    {
        $search = $request->input('search');

        if ($search == "") return "";

        $technicains = Technicain::where('fullname', 'LIKE', "%$search%")->get();
        $me = Auth::guard('employee')->user();
        return view('employee.dashboard.technicain-searchview', compact('technicains', 'me'))->render();
    }

    public function setCustomerState(Request $request)
    {
        $customer = Customer::find($request->input('customerID'));
        $state = $request->input('state');

        if ($state != 'Active' && $state != 'Inactive' && $state != 'Bloced')
            return Controller::jsonMessage('البيانات غير صحيحة', 1);

        if (!$customer)
            return Controller::jsonMessage('الزبون غير موجود', 1);

        $customer->state = $state;
        $customer->save();

        return Controller::jsonMessage('تم تحديث حالة الزبون بنجاح', 0);
    }

    public function financeReport(Request $request)
    {
        $year = $request->input('year');
        if ($year < 2024 || $year > now()->year) {
            return Controller::jsonMessage('التاريخ لا يمكن ان يكون قبل 2024 او تاريخ سابق لأوانه', 1);
        }

        // subscription information 
        $subs = WalletTransaction::selectRaw('month(created_at) as _month')
            ->selectRaw('sum(money) as _total')
            ->selectRaw('count(*) as _count')
            ->whereRaw('year(created_at) = ?', [$year])
            ->where('type', 'sub')
            ->groupByRaw('_month')
            ->orderByRaw('_month')->get();
        $subsMoneyPerMonth = [['شهر', 'قيمة']];
        $subsCountPerMonth = [['شهر', 'عدد']];
        foreach ($subs as $sub) {
            array_push($subsMoneyPerMonth, [$sub->_month, (float)$sub->_total]);
            array_push($subsCountPerMonth, [$sub->_month, $sub->_count]);
        }
        // adding missing months data (sometimes you get no data for some months so we add them manually)
        if (count($subsCountPerMonth) < 13) {
            $undefinedMonths = 1;
            while (true) {
                if ($undefinedMonths == 13) break;
                $found = false;
                for ($i = 0; $i < count($subsMoneyPerMonth); $i++) {
                    if ($subsMoneyPerMonth[$i][0] == $undefinedMonths) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    array_push($subsMoneyPerMonth, [$undefinedMonths, 0]);
                    array_push($subsCountPerMonth, [$undefinedMonths, 0]);
                }
                $undefinedMonths++;
            }

            // sort arrays
            $firstRow = array_shift($subsMoneyPerMonth);
            $monthNumbers = array_column($subsMoneyPerMonth, 0);
            array_multisort($monthNumbers, SORT_ASC, $subsMoneyPerMonth);
            array_unshift($subsMoneyPerMonth, $firstRow);

            $firstRow = array_shift($subsCountPerMonth);
            $monthNumbers = array_column($subsCountPerMonth, 0);
            array_multisort($monthNumbers, SORT_ASC, $subsCountPerMonth);
            array_unshift($subsCountPerMonth, $firstRow);
        }

        // $$$$$$$$$$ FINISHED $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$

        // prepaidcards information 
        $cards = PrepaidCard::selectRaw('state')
            ->selectRaw('count(*) as _count')
            ->whereRaw('year(created_at) = ?', [$year])
            ->groupByRaw('state')->get();
        $cardsTotalCount = 0;
        $prepaidcardsInformation = [['حالة', 'نسبة']];
        foreach ($cards as $cardGroup)
            $cardsTotalCount += $cardGroup->_count;
        foreach ($cards as $cardGroup) {
            array_push(
                $prepaidcardsInformation,
                [($cardGroup->state == 'Active' ? 'غير معبئة'
                    : ($cardGroup->state == 'Used' ? 'معبئة' : 'ملغية')), round(($cardGroup->_count / $cardsTotalCount) * 100, 2)]
            );
        }
        // $$$$$$$$$$ FINISHED $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$


        // fav prepaidcards information 
        $favCards = PrepaidCard::selectRaw('money')
            ->selectRaw('count(*) as _count')
            ->whereRaw('year(created_at) = ?', [$year])
            ->groupByRaw('money')->get();
        $favCardsTotalCount = 0;
        $favPrepaidcardsInformation = [['فئة', 'نسبة']];
        foreach ($favCards as $cardGroup)
            $favCardsTotalCount += $cardGroup->_count;
        foreach ($favCards as $cardGroup) {
            array_push(
                $favPrepaidcardsInformation,
                ["فئة $cardGroup->money دينار", round(($cardGroup->_count / $cardsTotalCount) * 100, 2)]
            );
        }
        // $$$$$$$$$$ FINISHED $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
        $object = [
            'subscriptionMoneyPerMonth' => $subsMoneyPerMonth,
            'subscriptionCountPerMonth' => $subsCountPerMonth,
            'generatedPrepaidcardsInfo' => $prepaidcardsInformation,
            'favPrepaidcardsInfo' => $favPrepaidcardsInformation,
            'systemMoney' => Employee::getSystem()->wallet->balance
        ];

        return Controller::jsonMessage($object, 0);
    }

    public function setTechnicainState(Request $request)
    {
        $technicain = Technicain::find($request->input('technicainID'));
        $state = $request->input('state');

        if ($state != 'Active' && $state != 'Inactive' && $state != 'Bloced')
            return Controller::jsonMessage('البيانات غير صحيحة', 1);

        if (!$technicain)
            return Controller::jsonMessage('الفني غير موجود', 1);

        $technicain->state = $state;
        $technicain->save();

        return Controller::jsonMessage('تم تحديث حالة الفني بنجاح', 0);
    }
    public function loginview(Request $request)
    {
        return view('employee.loginview');
    }
    public function login(Request $request)
    {
        $credentials  = [
            "email" => $request->input('login_emial'),
            "password" => $request->input('login_password')
        ];

        $employee = Employee::where('email', $credentials['email'])
            ->first();
        if ($employee) {
            if (!$employee->hasPermission(Permission::PERMISSION_ALLOW_LOGIN_NAME)) {
                return Redirect("/login/employee/")->withErrors(["status" => "وصول غير مصرح. تم تقييد الوصول لهذا الحساب"]);
            }
        }
        if (Auth::guard($this->guard)->attempt($credentials, true)) {
            $request->session()->regenerate();
            return Redirect("/employee/");
        } else {
            return Redirect("/login/employee/")->withErrors(["status" => "وصول غير مصرح به. يسمح للموظفين فقط بالوصول"]);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard($this->guard)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login/employee");
    }
}
