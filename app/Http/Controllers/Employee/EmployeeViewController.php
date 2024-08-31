<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class EmployeeViewController extends Controller {
    private $guard = 'employee';
    public function index() {
        return view("employee.index", ['me' => Auth::guard($this->guard)->user()]);
    }
}