<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Auth\EmailUtility;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\PostComment;
use App\Models\PrepaidCard;
use App\Models\Rate;
use App\Models\Reservation;
use App\Models\Specialization;
use App\Models\Technicain;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerViewController extends Controller
{
    private $guard = 'customer';
    public function index()
    {
        $services = Specialization::all();
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        return view("customer.homepage", compact('services', 'me'));
    }

    public function deleteComment(Request $request, $id)
    {
        $comment = PostComment::find($id);

        if ($comment->owner->id == Auth::guard($this->guard)->user()->id)
            $comment->delete();
        else
            return redirect()->back()->withErrors(['access-denied', 'طلب غير مسموح به']);
        return redirect()->back()->with('task-complet', 'تم حذف تعليقك بنجاح');
    }
    public function myWallet()
    {
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        return view("customer.mywallet", compact('me'));
    }
    public function myReservation()
    {
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        $reservations = Reservation::where('customer_id', $me->id)->orderBy('date', 'desc')->get();
        return view("customer.myreservations", compact('me', 'reservations'));
    }
    /**
     * Add new comment sent by a customer and save it 
     * Data sent: id of the customer, post-id of the post and the comment for the post
     * For AJAX Only
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function addComment(Request $request)
    {

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


    public function search(Request $request)
    {
        $customer = Customer::find(Auth::guard($this->guard)->user()->id);
        $value = $request->input('technicain');

        // search for specializations first:
        $results = Specialization::where('name', 'like', "%$value%")->first();
        if ($results == null) {
            // search by technicain name
            $results = Technicain::where('fullname', 'like', "%$value%")
                ->where('state', 'Active')
                ->where('address', 'like', "%$customer->address%")
                ->get();
            // ->orWhere('address', 'like', "%$customer->address%")
            // ->where('state', 'Active')->get();
        } else {
            // search by specialization'id
            $specializeId = $results->id;
            $results = Technicain::where('specialization_id', $specializeId)
                ->where('state', 'Active')
                ->where('address', 'like', "%$customer->address%")->get();
        }

        // foreach($results as $technicain) 
        //     $technicain->processRate();

        return Controller::whichReturn($request, '/', Controller::jsonMessage($results, 0));
    }

    public function addReservation(Request $request, $techId)
    {
        $technicain = Technicain::find($techId);
        $customer = Customer::find(Auth::guard($this->guard)->user()->id);
        if ($technicain == null)
            return Controller::whichReturn(
                $request,
                '/',
                Controller::jsonMessage('الفني غير موجود فالنظام', 1)
            );

        if ($technicain->state != 'Active')
            return Controller::whichReturn(
                $request,
                '/',
                Controller::jsonMessage('فشل الحجز. اعد المحاولة لاحقا', 1)
            );

        if ($customer->wallet->balance < 15) {
            return Controller::whichReturn(
                $request,
                '/',
                Controller::jsonMessage('لا يمكنك الحجز لان محفظتك لا تحتوي على الرصيم الكافي للحجز - 15د.ل ', 1)
            );
        }
        $dateString = $request->input('date');
        $date = Carbon::createFromFormat('d-m-Y', $dateString);

        // check if user have an active reservation in this Specialization
        $reservations = Reservation::where('customer_id', $customer->id)
            ->where('state', '!=', 'Refused')
            ->where('state', '!=', 'Done')
            ->orWhere('customer_id', $customer->id)
            ->where('state', 'Accepted')->get();
        if ($reservations->count() > 0) {
            foreach ($reservations as $r) {
                if ($r->technicain()->specialization_id == $technicain->specialization_id) {
                    return Controller::whichReturn(
                        $request,
                        '/',
                        Controller::jsonMessage('لا يمكنك حجز اكثر من فني من نفس التخصص في نفس الوقت. قم بالغاء احد الحجوزات اولا', 1)
                    );
                }
            }
        }

        // register the reservation
        $r = Reservation::create([
            'customer_id' => $customer->id,
            'technicain_id' => $technicain->id,
            'state' => 'Pending',
            'date' => $date,
            //'description' => ""
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
        return Controller::whichReturn(
            $request,
            '/',
            Controller::jsonMessage('تم الحجز بنجاح', 0)
        );
    }

    public function cancelReservation(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if ($reservation == null) {
            return redirect()->back()->withErrors(['unknwon-re' => "الحجز غير معرف في النظام"]);
        }

        if ($reservation->state == 'InProgress') {
            return redirect()->back()->withErrors(['unable-tocancel-re' => "لا يمكنك الغاء حجز في حالة قيد العمل"]);
        }
        $customer = $reservation->customer();
        $reservationDate = $reservation->date;

        // We need to check if user just made the reservation in past day(s)
        $creationAndReservationDateDiff = Carbon::parse($reservationDate)->diffInHours($reservation->created_at);
        if ($creationAndReservationDateDiff < 48 && $creationAndReservationDateDiff > 0) {
            // in case the customer made the reservation in the same day  and want to cancel..
            $reservation->state = "Refused";
            $reservation->save();
            return redirect()->back()->with('task-complet', 'تم الغاء الحجز بنجاح');
        }
        $now = now();
        $df = $now->diffInHours($reservationDate);
        if ($df < 0) {
            // if tecnicain forgot to mark it as completed .. 
            $reservation->state = "Done";
            $reservation->save();
            return redirect()->back()->withErrors(['unable-tocancel-re' => "تاريخ الحجز قديم. تم تعيينه كـ مكتمل"]);
        }

        if ($df < 25) {
            $desc = "قام النظام بخصم قيمة 15د.ل نظرا لانك قمت بإلغاء حجز لم  يتبقى عليه اكتر من 24 ساعة او اقل";
            $system = Employee::getSystem();
            $systemWallet = $system->wallet;
            $wallet = $customer->wallet;

            if ($wallet->balance < 15) {
                return redirect()->back()->withErrors(['unable-tocancel-re' => "لا يمكنك الغاء الحجز. رصيد محفظتك اقل من الحد الادنى"]);
            }

            WalletTransaction::create([
                'wallet_in_id' => $systemWallet->id,
                'wallet_out_id' => $wallet->id,
                'money' => 15,
                'description' => $desc,
                'type' => "Other",
                'due' => now()
            ]);

            $email = new \App\Mail\TransactionsEmail([
                'inWallet' => $systemWallet,
                'outWallet' => $wallet,
                'balance' => 15,
                'type' => 'Other',
                'desc' =>  $desc,
                'due' => now()
            ]);


            $systemWallet->balance += 15;
            $systemWallet->save();
            $wallet->balance -= 15;
            $wallet->save();

            Mail::to($customer->email)->send($email);
            return redirect()->back()->with('task-complet', 'تم الغاء الحجز بنجاح');
        } else {
            $reservation->state = "Refused";
            $reservation->save();
            return redirect()->back()->with('task-complet', 'تم الغاء الحجز بنجاح');
        }
    }


    public function editView(Request $request)
    {
        $me = Customer::find(Auth::guard($this->guard)->user()->id);
        return view("customer.edit", compact('me'));
    }


    public function setProfileImage(Request $request)
    {
        try {
            //code...
            $result = EmailUtility::setProfileImage($request, 'customer');

            if (!$result) {
                throw new \Exception(" EmailUtility::setProfileImage() result is false");
            } else {
                return Controller::whichReturn(
                    $request,
                    redirect()->back()->with('image-updated', true),
                    Controller::jsonMessage('تم تغيير الصورة الشخصية بنجاح', 0),
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            return Controller::whichReturn(
                $request,
                redirect()->back()->with('image-updated', false),
                Controller::jsonMessage('حدثت مشكلة اثناء تغيير صورة الحساب', 0),
            );
        }
    }

    public function edit(Request $request)
    {
        $v = Validator::make($request->all(), [
            'customer_name_edit' => 'required|string|max:90|min:8',
            'customer_db_edit' => 'required|before:1/1/2005',
            'customer_phone_edit' => 'required|regex:/(218)[0-9]{9}/',
            'customer_address_edit' => 'required',
            'customer_gender_edit' => 'required',
        ], [
            'customer_name_edit.required' => 'حقل الاسم مطلوب .',
            'customer_name_edit.max' => 'حقل الاسم يجب ان يتكون من اقل من 90 حرف .',
            'customer_name_edit.min' => 'حقل الاسم يجب ان يتكون من 8 احرف او اكتر .',
            'customer_gender_edit.required' => 'حقل الجنس مطلوب.',
            'customer_phone_edit.required' => 'حقل الهاتف مطلوب.',
            'customer_address_edit.required' => 'حقل العوان مطلوب.',
            'customer_phone_edit.regex' => 'رقم الهاتف غير صحيح',
            'customer_db_edit.required' => 'تاريخ الميلاد مطلوب',
            'customer_db_edit.before' => 'تاريخ الميلاد لا يجب ان يكون بعد 2010',
        ]);
        if (!$v->fails()) {
            $user = Customer::find(Auth::guard($this->guard)->user()->id);
            if ($user != null) {
                $user->fullname = $request->input('customer_name_edit');
                $user->phone = $request->input('customer_phone_edit');
                $user->address = $request->input('customer_address_edit');
                $user->gender = $request->input('customer_gender_edit');
                $user->birthdate = $request->input('customer_db_edit');
                $user->save();
                return redirect()->back()->with('task-complet', "تم تحديث بياناتك بنجاح");
            }
        }
        return redirect()->back()->withErrors($v->errors())->withInput();
    }



    public function topUp(Request $request)
    {
        $v = Validator::make($request->all(), [
            'prepaidcard_number' => 'required',
        ], [
            'prepaidcard_number.required' => 'حقل رقم البطاقة مطلوب .',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        // get user
        $user = Auth::guard($this->guard)->user();
        $card = PrepaidCard::where('serial', $request->input('prepaidcard_number'))
            ->where('state', 'Active')->first();

        if (!$card) {
            return redirect()->back()->withErrors(['unknown-card' => "رقم بطاقة الشحن غير صحيح"]);
        }


        $wallet = $user->wallet;
        $wallet->balance += $card->money;
        $wallet->save();
        $card->state = "Used";
        $card->markAsTransaction($user);
        $card->save();

        return redirect()->back()->with('task-complet', "تم تعبئة المحفظة بقيمة " . $card->money . " د.ل ");
    }


    public function rateTechnicain(Request $request, $id, $stars)
    {
        $customerID = Auth::guard($this->guard)->user()->id;
        $technicain = Technicain::find($id);

        if ($stars < 1 || $stars > 5) {
            return Controller::jsonMessage("الصيغة غير صحيحة. فشلت عملية التقييم", 1);
        }

        if (!$technicain) {
            return Controller::jsonMessage("الفني غير موجود", 1);
        }

        // check for previous record
        $rate = Rate::where('customer_id', $customerID)->first();

        if ($rate) {
            // Yes i have already rated this tech!
            // let's modify the value and we're done!
            $rate->rate = $stars;
            $rate->save();
        } else {
            // save the brand bew record.
            Rate::create([
                "customer_id" => $customerID,
                "technicain_id" => $technicain->id,
                "rate" => $stars
            ]);
        }

        return Controller::jsonMessage("تم تقييم الفني بنجاح", 0);
    }
}
