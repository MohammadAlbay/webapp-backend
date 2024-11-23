<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NSFWController;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Technicain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use necrox87\NudityDetector\Image;
use necrox87\NudityDetector\NudityDetector;

class EmailUtility extends Controller
{
    public static function getEmailOwner($email)
    {
        Log::info("Email >" . $email);
        $tempUser = Customer::where('email', $email)->first();
        if ($tempUser != null)
            return 'customer';

        $tempUser = Technicain::where('email', $email)->first();
        if ($tempUser != null)
            return 'technicain';

        $tempUser = Employee::where('email', $email)->first();
        if ($tempUser != null)
            return 'employee';

        return null;
    }


    public static function setProfileImage(Request $request, $user_type)
    {
        error_reporting(E_ERROR | E_PARSE);

        if ($user_type == 'customer')
            $user = Customer::find(Auth::guard('customer')->user()->id);
        else if ($user_type == 'technicain')
            $user = Technicain::find(Auth::guard('technicain')->user()->id);
        else if ($user_type == 'employee')
            $user = Employee::find(Auth::guard('employee')->user()->id);
        else
            $user = null;

        if ($user == null) return false;

        $img = $request->file('img');
        $fileName = $img->getClientOriginalName();
        //$file->store(public_path()."/cloud/$user_type/$user->id/images");
        $path = public_path() . "\\cloud\\$user_type\\$user->id\\images\\$fileName";
        $img->move(public_path() . "/cloud/$user_type/$user->id/images/", $fileName);
        // detect if image is NSFW
        $result = NSFWController::detect($path);

        if ($result["safe"]) {
            // delete old image
            try {
                unlink(public_path() . "\\cloud\\$user_type\\$user->id\\images\\$user->profile");
            } catch (\Exception $e) {
            }
            // safe new image
            $user->profile = $fileName;
            $user->save();
            return true;
        } else {
            unlink($path);
            return false;
        }
    }




    public static function setProfileImageFor($request, $user, $user_type)
    {
        error_reporting(E_ERROR | E_PARSE);

        $img = $request->file('img');
        $fileName = $img->getClientOriginalName();
        //$file->store(public_path()."/cloud/$user_type/$user->id/images");
        $path = public_path() . "\\cloud\\$user_type\\$user->id\\images\\$fileName";
        $img->move(public_path() . "/cloud/$user_type/$user->id/images/", $fileName);
        // detect if image is NSFW
        $result = NSFWController::detect($path);

        if ($result["safe"]) {
            // delete old image
            try {
                unlink(public_path() . "\\cloud\\$user_type\\$user->id\\images\\$user->profile");
            } catch (\Exception $e) {
            }
            // safe new image
            $user->profile = $fileName;
            $user->save();
            return true;
        } else {
            unlink($path);
            return false;
        }
    }
}
