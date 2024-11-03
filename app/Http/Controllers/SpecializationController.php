<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;

class SpecializationController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = $request->get('search');
        $specializations = Specialization::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })->paginate(12);
        
        $me = Auth::guard('customer')->check() ? Customer::find(Auth::guard('customer')->user()->id) : null;
        
        if($me == null)
            return view('specializations', compact('specializations', 'query'));
        else
            return view('specializations', compact('specializations', 'query', 'me'));
    }

    public function showTechnicians($id)
    {
        $specialization = Specialization::findOrFail($id);
        $technicians = $specialization->technicains; // Get technicians associated with the specialization
        $me = Auth::guard('customer')->check() ? Customer::find(Auth::guard('customer')->user()->id) : null;

        if($me == null)
            return view('technicians', compact('specialization', 'technicians'));
        else
        return view('technicians', compact('me','specialization', 'technicians'));
    }

    /////


}
