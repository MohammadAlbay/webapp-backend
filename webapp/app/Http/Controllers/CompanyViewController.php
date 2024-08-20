<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Programmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyViewController extends Controller
{
    public function index() {
        return view("company.index");
    }
}