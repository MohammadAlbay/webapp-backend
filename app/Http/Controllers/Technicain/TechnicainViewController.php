<?php
namespace App\Http\Controllers\Technicain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class TechnicainViewController extends Controller {
    private $guard = 'customer';
    public function index() {
        return view("technicain.mdashboard.index", ['me' => Auth::guard($this->guard)->user()]);
    }
   

}