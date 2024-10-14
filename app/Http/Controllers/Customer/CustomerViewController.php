<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PostComment;
use App\Models\Reservation;
use App\Models\Specialization;
use App\Models\Technicain;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerViewController extends Controller {
    private $guard = 'customer';
    public function index() {
        $services = Specialization::all();
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        return view("customer.homepage", compact('services', 'me'));
    }

    public function myReservation() {
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        $reservations = Reservation::where('customer_id', $me->id)->orderBy('date', 'asc')->get();
        return view("customer.myreservations", compact( 'me', 'reservations'));
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


    public function search(Request $request) {
        $customer = Customer::find(Auth::guard($this->guard)->user()->id);
        $value = $request->input('technicain');

        // search for specializations first:
        $results = Specialization::where('name', 'like', "%$value%")->first();
        if($results == null) {
            // search by technicain name
            $results = Technicain::where('fullname', 'like', "%$value%")
                        ->where('state', 'Active')
                        ->orWhere('address', 'like', "%$customer->address%")
                        ->where('state', 'Active')->get();
        } else {
            // search by specialization'id
            $specializeId = $results->id;
            $results = Technicain::where('specialization_id', $specializeId)
                        ->where('state', 'Active')
                        ->where('address', 'like', "%$customer->address%")->get();
        }

        return Controller::whichReturn($request, '/', Controller::jsonMessage($results, 0));
        
    }

    public function addReservation(Request $request, $techId) {
        $technicain = Technicain::find($techId);
        $customer = Customer::find(Auth::guard($this->guard)->user()->id);
        if($technicain == null)
            return Controller::whichReturn($request, '/', 
                    Controller::jsonMessage('الفني غير موجود فالنظام', 1));
        
        if($customer->wallet->balance < 15) {
            return Controller::whichReturn($request, '/', 
                    Controller::jsonMessage('لا يمكنك الحجز لان محفظتك لا تحتوي على الرصيم الكافي للحجز - 15د.ل ', 1));
        }
        $dateString = $request->input('date');
        $date = Carbon::createFromFormat('d-m-Y', $dateString);
        
        // check if user have an active reservation in this Specialization
        $reservations = Reservation::where('customer_id', $customer->id)
                                    ->where('state', 'Pending')
                                    ->orWhere('customer_id', $customer->id)
                                    ->where('state', 'Accepted')->get();
        if($reservations->count() > 0) {
            foreach($reservations as $r) {
                if($r->technicain()->specialization_id == $technicain->specialization_id)   {
                    return Controller::whichReturn($request, '/', 
                    Controller::jsonMessage('لا يمكنك حجز اكثر من فني من نفس التخصص في نفس الوقت. قم بالغاء احد الحجوزات اولا', 1));
                }
            }
        }

        // register the reservation
        $r = Reservation::create([
            'customer_id' => $customer->id,
            'technicain_id' => $technicain->id,
            'state' => 'Pending',
            'date' => $date,
            'description' => ""
        ]);

        $data = [
            'from' => 'customer',
            'customer' => $customer,
            'technicain' => $technicain,
            'date' => $date,
            'id' => $r->id,
            'url' => $url = request()->getSchemeAndHttpHost()
        ];
        Mail::to($technicain->email)->send(new \App\Mail\ReservationEmail($data));
        return Controller::whichReturn($request, '/', 
                    Controller::jsonMessage('تم الحجز بنجاح', 0));
    }
}