<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PrepaidCard;
use App\Models\Specialization;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends Controller
{

    public function create(Request $request) {
        $name = $request->input('name');

        $rules = [
            'specialization_name' =>  'required:max:32|min:4'
        ];
        $messages = [
            'specialization_name.required' => 'حقل اسم التخصص مطلوب.',
            'specialization_name.min' => 'اسم التخصص يجب ان تتكون من 4 احرف وارقام على الاقل',
        ];
        
        // Create a validator instance
        $validator = Validator::make(['specialization_name' => $name], $rules, $messages);

        if ($validator->fails()) {
            $err = $validator->errors();
            return Controller::whichReturn(
                $request,
                redirect("/signup/employee/")->withErrors(["error" => $err->first($err->keys()[0])])->withInput(),
                Controller::jsonMessage($err->first($err->keys()[0]), 1)
            );
        }

        if(Specialization::where('name', $name)
                    ->count() != 0) {
            return 
            Controller::jsonMessage("اسم التخصص هذا مسجل بالفعل", 1);
        }

        Specialization::create([
            'name' => $name, 'image' => 'general.png'
        ]);

        return Controller::jsonMessage("تم اضافة التخصص", 0);
    }

    public function switchstate(Request $request, $id) {
        // to add permission check here
        $specialization = Specialization::find($id);

        if($specialization == null) return Controller::whichReturn($request, 
             redirect('/employee')->withError(['UnknowCard', 'لم يتم التعرف على التخصص']),
            Controller::jsonMessage('لم يتم التعرف على التخصص', 1));

        $specialization->state = $specialization->state == 'Active' ? 'Inactive' : 'Active';
        $specialization->save();

        return Controller::whichReturn($request,
        redirect('/employee'),
        Controller::jsonMessage("تم حفظ التغييرات", 0));
    }

    public function setName(Request $request, $id) {
        $name = $request->input('name');

        $rules = [
            'specialization_name' =>  'required:max:32|min:4'
        ];
        $messages = [
            'specialization_name.required' => 'حقل اسم التخصص مطلوب.',
            'specialization_name.min' => 'اسم التخصص يجب ان تتكون من 4 احرف وارقام على الاقل',
        ];
        
        // Create a validator instance
        $validator = Validator::make(['specialization_name' => $name], $rules, $messages);

        if ($validator->fails()) {
            $err = $validator->errors();
            return Controller::whichReturn(
                $request,
                redirect("/signup/employee/")->withErrors(["error" => $err->first($err->keys()[0])])->withInput(),
                Controller::jsonMessage($err->first($err->keys()[0]), 1)
            );
        }

        if(Specialization::where('name', $name)
                ->where('id', '!=', $id)->count() != 0) {
            return 
            Controller::jsonMessage("اسم التخصص هذا مسجل بالفعل", 1);
        }

        $specialization = Specialization::find($id);

        if($specialization == null) return Controller::jsonMessage('لم يتم التعرف على التخصص', 1);
            

        $specialization->name = $name;
        $specialization->save();

        return Controller::jsonMessage("تم حفظ التغييرات", 0);
    }

    public function setImage(Request $request, $id) {
        $image = $request->file('image');

        $specialization = Specialization::find($id);

        if($specialization == null) return Controller::jsonMessage('لم يتم التعرف على التخصص', 1);

        $fileName = $image->getClientOriginalName();
        $image->move(public_path()."/sources/specializations/", $fileName);

        $specialization->image = $fileName;
        $specialization->save();

        return Controller::jsonMessage("تم حفظ التغييرات", 0);
    }
}
