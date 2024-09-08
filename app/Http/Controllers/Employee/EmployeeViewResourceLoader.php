<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;

class EmployeeViewResourceLoader extends Controller {
    public function manage(Request $request, $path) : View | Blade | String{
        try {
            $viewPath = "employee.dashboard.{$path}";
            if(!view()->exists($viewPath)) throw new Exception("Undefined Error");
            
            $params = [];
            //dd($path);
            if($path == "add-employee") {
                $params['roles'] = Role::all();
            }
            else if($path == "employee-list") {
                $params['employees'] = Employee::all();
            }
            //dd($params);
            return view($viewPath, $params);
        } catch(Exception $e) {
            return Blade::render('<h1>Undefined view {{$view}}', ['view' => $path]);
        }
        
    }
}