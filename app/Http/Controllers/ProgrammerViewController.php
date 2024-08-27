<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Programmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProgrammerViewController extends Controller
{
    public function index() {
        $projectList = [
            "M1", "A2", "None", "newproject"
        ];
        return view("programmer.index", ["projects" => $projectList]);
    }
}