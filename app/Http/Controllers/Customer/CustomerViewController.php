<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CustomerViewController extends Controller {
    private $guard = 'customer';
    public function index() {
        return view("customer.index", ['me' => Auth::guard($this->guard)->user()]);
    }
}