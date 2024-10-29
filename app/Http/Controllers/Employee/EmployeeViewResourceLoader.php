<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerReport;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Post;
use App\Models\PrepaidCard;
use App\Models\Rate;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\Technicain;
use App\Models\TechnicainReport;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class EmployeeViewResourceLoader extends Controller
{
    public function manage(Request $request, $path): View | Blade | String
    {
        try {
            $viewPath = "employee.dashboard.{$path}";
            if (!view()->exists($viewPath)) throw new Exception("Undefined Error");

            $params = [];
            //dd($path);
            if ($path == "homepage") {
                $params['techniainsCount'] = Technicain::selectRaw('count(*) as value')
                    ->where('state', '!=', 'Inactive')
                    ->first(['value']);
                $params['customersCount'] = Customer::selectRaw('count(*) as value')
                    ->where('state', '!=', 'Inactive')
                    ->first(['value']);
                $params['employeesCount'] = Employee::selectRaw('count(*) as value')
                    ->where('state', '!=', 'Inactive')
                    ->first(['value']);

                $params['postsDeployedCount'] = Post::selectRaw('count(*) value')
                    ->whereRaw('YEAR(created_at) = ?', [now()->year])
                    ->whereRaw('MONTH(created_at) = ?', [now()->month])
                    ->first(['value']);
                $params['averageRateCount'] = Rate::selectRaw('avg(rate) as value')
                    ->groupByRaw('rate')
                    ->first(['rate']);
                $params['techniainsInactiveCount'] = Technicain::selectRaw('count(*) as value')
                    ->where('state', '=', 'Inactive')
                    ->first(['value']);
                $params['technicainDistrobutions'] = Technicain::selectRaw('count(*) as value')
                    ->selectRaw('address')
                    ->groupByRaw('address')
                    ->where('state', '!=', 'Inactive')
                    ->get(['value', 'address']);
            } else if ($path == "finance-stats-report") {
                $params['systemWallet'] = Employee::getSystem()->wallet;
                $params['transactionTypeOther'] = WalletTransaction::selectRaw('sum(money) as value')
                    ->where('type', 'Other')
                    ->whereRaw('YEAR(created_at) = ?', [now()->year])
                    ->groupBy('money')
                    ->first(['value']);
                $params['transactionTypeSub'] = WalletTransaction::selectRaw('sum(money) as value')
                    ->where('type', 'Sub')
                    ->whereRaw('YEAR(created_at) = ?', [now()->year])
                    ->groupBy('money')
                    ->first(['value']);
            } else if ($path == "manage-customers") {
                $params['customers'] = Customer::latest('created_at')->take(100)->get();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "manage-technicain") {
                $params['technicains'] = Technicain::latest('created_at')->take(100)->get();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "manage-customers-reports") {
                $params['reports'] = CustomerReport::latest('created_at')->take(100)->get();
            } else if ($path == "manage-technicain-reports") {
                $params['reports'] = TechnicainReport::latest('created_at')->take(100)->get();
            } else if ($path == "edit-mydata") {
                $params['roles'] = Role::all();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "add-employee") {
                $params['roles'] = Role::all();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "employee-list") {
                $params['employees'] = Employee::all(['id', 'fullname', 'email', 'gender', 'phone', 'profile', 'address', 'role_id', 'state', 'created_at']);
                $params['roles'] = Role::all();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "permission-list") {
                $params['permissions'] = Permission::all();
                $params['roles'] = Role::all();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "role-list") {
                $params['permissions'] = Permission::all();
                $params['roles'] = Role::all();
                $params['me'] = Auth::guard('employee')->user();
            } else if ($path == "prepaidcards-list") {
                $params['prepaidcardGenerations'] = PrepaidCard::getGenerationsDetails();
            } else if ($path == "specializations-list") {
                $params['specializations'] = Specialization::all();
            } else if ($path == "specializations-list") {
                $params['specializations'] = Specialization::all();
            }
            return view($viewPath, $params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return Blade::render('<h1>Undefined view {{$view}}', ['view' => $path]);
        }
    }
}
