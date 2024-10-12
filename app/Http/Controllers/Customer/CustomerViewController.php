<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PostComment;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerViewController extends Controller {
    private $guard = 'customer';
    public function index() {
        $services = Specialization::all();
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        return view("customer.homepage", compact('services', 'me'));
    }

    /**
     * Add new comment sent by a customer and save it 
     * Data sent: id of the customer, post-id of the post and the comment for the post
     * For AJAX Only
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function addComment(Request $request) {
        
        $v = Validator::make($request->all(), [
            'post-id' => 'required',
            'comment' => 'required',
        ], [
            'post-id.required' => 'حقل معرف المنشور مطلوب .',
            'comment.required' => 'حقل التعليق مطلوب .',
        ]);
        if ($v->fails()) {
            return response()->json(Controller::jsonMessage('المدخلات غير صحيحة', 1));
        }

        $customer = Customer::find(Auth::guard($this->guard)->user()->id);
        $postComment = PostComment::create([
            'post_id' => $request->input('post-id'),
            'owner_id' => $customer->id,
            'owner_type' => get_class($customer),
            'comment' => $request->input('comment')
        ]);

        return response()->json(Controller::jsonMessage('تم اضافة تعليقك بنجاح', 0));
    }
}