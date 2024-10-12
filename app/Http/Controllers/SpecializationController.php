<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;

class SpecializationController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = $request->get('search');
        $specializations = Specialization::when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })->paginate(4);
        
        return view('specializations', compact('specializations', 'query'));
    }

    public function showTechnicians($id)
    {
        $specialization = Specialization::findOrFail($id);
        $technicians = $specialization->technicains; // Get technicians associated with the specialization

        return view('technicians', compact('specialization', 'technicians'));
    }

    /////


}
