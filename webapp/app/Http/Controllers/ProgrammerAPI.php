<?php

namespace App\Http\Controllers;

use App\Models\Programmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgrammerAPI extends Controller
{
    public function index($id = null) {
        if($id !== null)
            return response()->json(Programmer::find($id));
        return response()->json(Programmer::all()); 
    }

    public function update($id, $name) {
        $programmer = Programmer::find($id);
        if($programmer) {
            $programmer->fullname = $name;
            $programmer->save();
        }
        return $programmer == null ? response()->json(["message" => "failed to update"]) :
        response()->json(["message" => "successfully updated"]);
    }

    public function store(Request $request) {
        // ... all data
        $data = [
            // "fullname" => $request->input("fullname_signup_api")
            //..
        ];
        $newProgrammer = Programmer::create($data);
    }

    public function destroy($id) {
        Programmer::destroy(["id" => $id]);
        
    }
}
