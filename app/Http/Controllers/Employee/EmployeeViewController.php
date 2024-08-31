<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class EmployeeViewController extends Controller {
    private $guard = 'employee';
    public function index() {
        return view("employee.index", ['me' => Auth::guard($this->guard)->user()]);
    }

    public function addSpecialization(Request $request) {
        $name = $request->input('spec_name');
        
        Specialization::create([
           "name" => $name
        ]);

        return redirect('/employee/')->with(['done' => "Saved!"]);
    }
}