<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Specialization;

class HomeController extends Controller
{
    //
    public function index()
    {
        /* i made controll to fetch all Specialization */
        $services = Specialization::all(); // Fetch all services
        $loginInformation = $this->getLoginInformation(); // Contains array descriping user type and an instance of user (IF logged in)

        return view('homepage', compact('services', 'loginInformation')); // Pass services to the view
    }

    private function getLoginInformation()
    {
        $userGuard = null;

        $guars =  [
            'customer',
            'technicain',
            'employee'
        ];

        foreach ($guars as $guard) {
            if (!Auth::guard($guard)->guest()) {
                $userGuard = $guard;
                break;
            }
        }

        $associatedData = [];
        if ($userGuard) {
            $associatedData = [
                'userType' => $userGuard ?? '',
                'user' => Auth::guard($userGuard)->user()
            ];
        }

        return $associatedData;
    }
}
