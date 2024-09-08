<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    //


    public static function whichReturn(Request $request, $any, $json) {
        if($request->isJson() || $request->wantsJson() || $request->ajax()) {
            return response()->json($json);
        } else {
            return $any;
        }
    }
}
