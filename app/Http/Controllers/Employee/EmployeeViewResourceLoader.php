<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\PrepaidCard;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\Technicain;
use Exception;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\View;
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
            if ($path == "add-employee") {
                $params['roles'] = Role::all();
            } else if ($path == "employee-list") {
                $params['employees'] = Employee::all(['id', 'fullname', 'email', 'gender', 'phone', 'profile', 'address', 'role_id', 'state', 'created_at']);
                $params['roles'] = Role::all();
            } else if ($path == "permission-list") {
                $params['permissions'] = Permission::all();
                $params['roles'] = Role::all();
            } else if ($path == "role-list") {
                $params['permissions'] = Permission::all();
                $params['roles'] = Role::all();
            } else if ($path == "prepaidcards-list") {
                $params['prepaidcardGenerations'] = PrepaidCard::getGenerationsDetails();
            }
            // Rahma was here :)
            // if i did something wrong forgiveme mohammad :)
            else if ($path == "Technician-list") {
                $params['technicians'] = Technicain::all(['id', 'profile', 'fullname', 'email', 'phone', 'nationality', 'address', 'specialization_id', 'created_at', 'state']);
                $params['Specialization'] = Specialization::all();
            }
            return view($viewPath, $params);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return Blade::render('<h1>Undefined view {{$view}}', ['view' => $path]);
        }
    }
}
