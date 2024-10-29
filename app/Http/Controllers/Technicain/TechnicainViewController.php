<?php

namespace App\Http\Controllers\Technicain;

use App\Http\Controllers\Auth\EmailUtility;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostImage;
use App\Models\PrepaidCard;
use App\Models\Reservation;
use App\Models\Specialization;
use App\Models\Technicain;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TechnicainViewController extends Controller
{
    private $guard = 'technicain';
    public function index(Request $request, $id = null)
    {



        return view("technicain.mdashboard.index", ['me' => Auth::guard($this->guard)->user(), 'viewer' => '']);
    }

    public function viewPreviouseWork(Request $request)
    {
        $me = Technicain::find(Auth::guard($this->guard)->user()->id);
        return view('technicain.mdashboard.previouse-work', [
            'me' => $me,
            'reservations' => Reservation::where('technicain_id', $me->id)->where('state', 'Done')->paginate(20)
        ]);
    }
    public function viewScheduedWork(Request $request)
    {
        $me = Technicain::find(Auth::guard($this->guard)->user()->id);
        return view('technicain.mdashboard.scheduled-work', [
            'me' => $me,
            'reservations' => Reservation::where('technicain_id', $me->id)->where('state', '!=', 'Done')->paginate(20)
        ]);
    }
    public function viewPosts(Request $request)
    {
        $me = Technicain::find(Auth::guard($this->guard)->user()->id);
        $viewer = '';
        $posts = Post::where(
            'technicain_id',
            Auth::guard($this->guard)->user()->id
        )->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax() || $request->wantsJson()) {
            return view('technicain.mdashboard.post', compact('posts', 'me', 'viewer'))->render();
        }

        return view(
            'technicain.mdashboard.postsview',
            [
                'me' => $me,
                'viewer' => $viewer,
                'posts' => $posts,
                // 'specialization' => Specialization::where('state', 'Active')->get()
            ]
        );
    }

    public function viewSubscription(Request $request)
    {
        return view('technicain.mdashboard.subscription', [
            'me' => Technicain::find(Auth::guard($this->guard)->user()->id),
        ]);
    }
    public function viewWallet(Request $request)
    {
        return view('technicain.mdashboard.wallet', [
            'me' => Technicain::find(Auth::guard($this->guard)->user()->id),
        ]);
    }

    public function viewProfileSupervised(Request $request, $id = null) {
        $posts = Post::where(
            'technicain_id',
            $id ?? Auth::guard($this->guard)->user()->id
        )->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax() || $request->wantsJson()) {
            return view('technicain.mdashboard.post', compact('posts'))->render();
        }


        $tech = Technicain::find($id);
        $viewer = Employee::find(Auth::guard(name: 'employee')->user()->id);
        $reservation = Reservation::where('technicain_id', $tech->id)
                            ->where('customer_id', $viewer->id)
                            ->where('state', 'Done')->latest()->first();

        if ($tech == null) {
            return redirect()->back();
        }

        return view(
            'technicain.mdashboard.profile-supervised',
            [
                'me' => $tech,
                'viewer' => $viewer,
                'posts' => $posts,
                'specialization' => Specialization::where('state', 'Active')->get(),
                'reservation' => $reservation,
                'no_comments' => true
            ]
        );
    }
    public function viewProfile(Request $request, $id = null)
    {

        $posts = Post::where(
            'technicain_id',
            $id ?? Auth::guard($this->guard)->user()->id
        )->orderBy('created_at', 'desc')->paginate(5);

        if ($request->ajax() || $request->wantsJson()) {
            return view('technicain.mdashboard.post', compact('posts'))->render();
        }

        $viewer = null;
        $reservation = null;
        if ($id ==  null) {
            $tech = Auth::guard($this->guard)->user();
            $viewer = '';
        } else {
            $tech = Technicain::find($id);
            $viewer = Customer::find(Auth::guard('customer')->user()->id);
            $reservation = Reservation::where('technicain_id', $tech->id)
                ->where('customer_id', $viewer->id)
                ->where('state', 'Done')->latest()->first();
        }

        if ($tech == null) {
            return redirect()->back();
        }

        return view(
            'technicain.mdashboard.profile',
            [
                'me' => $tech,
                'viewer' => $viewer,
                'posts' => $posts,
                'specialization' => Specialization::where('state', 'Active')->get(),
                'reservation' => $reservation
            ]
        );
    }

    public function setCoverImage(Request $request)
    {
        try {
            $user = Technicain::find(Auth::guard('technicain')->user()->id);
            $img = $request->file('img');
            $fileName = $img->getClientOriginalName();
            //$file->store(public_path()."/cloud/$user_type/$user->id/images");
            $img->move(public_path() . "/cloud/technicain/$user->id/images/", $fileName);

            $user->cover = $fileName;
            $user->save();

            return Controller::whichReturn(
                $request,
                redirect()->back()->with('image-updated', true),
                Controller::jsonMessage('تم تغيير صورة الغلاف بنجاح', 0),
            );
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            return Controller::whichReturn(
                $request,
                redirect()->back()->with('image-updated', false),
                Controller::jsonMessage('حدثت مشكلة اثناء تغيير صورة الغلاف', 0),
            );
        }
    }

    public function setProfileImage(Request $request)
    {
        try {
            //code...
            $result = EmailUtility::setProfileImage($request, 'technicain');

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
            'technicain_field_name' => 'required|string|max:90|min:8',
            'technicain_field_gender' => 'required',
            'technicain_field_nationality' => 'required',
            'technicain_field_phone' => 'required|regex:/(218)[0-9]{9}/',
            'technicain_field_address' => 'required',
            'technicain_field_specialize' => 'required',
            'technicain_field_birthdate' => 'required|before:1/1/2005',
        ], [
            'technicain_field_name.required' => 'حقل الاسم مطلوب .',
            'technicain_field_name.max' => 'حقل الاسم يجب ان يتكون من اقل من 90 حرف .',
            'technicain_field_name.min' => 'حقل الاسم يجب ان يتكون من 8 احرف او اكتر .',
            'technicain_field_gender.required' => 'حقل الجنس مطلوب.',
            'technicain_field_nationality.required' => 'حقل الجنسية مطلوب.',
            'technicain_field_phone.required' => 'حقل الهاتف مطلوب.',
            'technicain_field_address.required' => 'حقل العنوان مطلوب.',
            'technicain_field_phone.regex' => 'رقم الهاتف غير صحيح',
            'technicain_field_birthdate.required' => 'تاريخ الميلاد مطلوب',
            'technicain_field_birthdate.before' => 'تاريخ الميلاد لا يجب ان يكون بعد 2005',
        ]);
        if (!$v->fails()) {
            $user = Technicain::find(Auth::guard($this->guard)->user()->id);
            if ($user != null) {
                $user->fullname = $request->input('technicain_field_name');
                $user->phone = $request->input('technicain_field_phone');
                $user->address = $request->input('technicain_field_address');
                $user->nationality = $request->input('technicain_field_nationality');
                $user->gender = $request->input('technicain_field_gender');
                $user->specialization_id = $request->input('technicain_field_specialize');
                $user->birthdate = $request->input('technicain_field_birthdate');
                $user->save();
                return redirect('/technicain/profile')->with('info-updated', true);
            }
        }


        return redirect()->back()->withErrors($v->errors())->withInput();
    }

    public function viewCustomers()
    {
        $me = Technicain::find(Auth::guard($this->guard)->user()->id);
        return view('technicain.mdashboard.mycustomers', [
            'me' => Auth::guard($this->guard)->user(),
            'customers' => Reservation::where('technicain_id', $me->id)->where('state', 'Done')->paginate(20)
        ]);
    }


    public function subscripe(Request $request)
    {

        $desc = "تم خصم قيمة 15د.ل من محفظتك للإشتراك في خدماتنا";
        // get user
        $user = Technicain::find(
            Auth::guard($this->guard)->user()->id
        );
        // get user wallet
        $wallet = $user->wallet;

        // get system wallet
        $systemWallet = Employee::getSystem()->wallet;

        // check if user have sufficient money (15 LYD)
        if ($wallet->balance < 15) {
            return redirect()->back()->withErrors(['insufficient-wallet' => "رصيد المحفظة غير كافي لإجراء الاشتراك"]);
        }

        // make the transaction
        $outTransaction = WalletTransaction::create([
            "due" => now()->addDays(30),
            "type" => "Sub",
            "description" => $desc,
            "money" => 15,
            "wallet_out_id" => $wallet->id,
            "wallet_in_id" => $systemWallet->id
        ]);

        // add to system wallet
        $systemWallet->balance += 15;
        $systemWallet->save();

        // substract from techniain wallet
        $wallet->balance -= 15;
        $wallet->save();

        // activate technicain account
        $user->state = "Active";
        $user->save();

        // send email for subscription
        $email = new \App\Mail\TransactionsEmail([
            'inWallet' => $systemWallet,
            'outWallet' => $wallet,
            'balance' => 15,
            'type' => 'Sub',
            'desc' =>  $desc,
            'due' => now()->addDays(30)->toString()
        ]);

        Mail::to($user->email)->send($email);

        return redirect()->back()->with('task-complet', "تم الاتشراك بنجاح ");
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

    public function editPost(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back()->withErrors(['unknown-post' => "المنشور غير موجود"]);
        }

        $me = Technicain::find(Auth::guard($this->guard)->user()->id);
        return view('technicain.mdashboard.editpost', compact('me', 'post'));
    }
    public function addPost(Request $request)
    {
        $v = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if ($v->failed()) {
            return Controller::jsonMessage('محتوى المنشور مطلوب', 1);
        }

        $technicain_id = Auth::guard($this->guard)->user()->id;

        $text = $request->input('text'); // post text
        $files = explode(",", $request->input('files-list')); // comma separated string of files sent
        // save the post first since we need the id for storing post images
        $post = Post::create([
            'technicain_id' => $technicain_id,
            'description' => $text
        ]);
        // now, we need to store the image(s) and video(s) to the technicain folder
        // located at /public/cloud/technicain/{$Technicain_ID}/documents
        // let's make a new folder for our newely created post in documents folder
        $userdir = public_path() . "/cloud/technicain/$technicain_id/documents";
        mkdir($userdir . "/$post->id");
        // store each media file into that folder.. 
        // as well as storing the post images into database
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $img = $request->file($file);

                $fileName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $img->getClientOriginalName());
                //$sanitizedFilename = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $originalName);
                $fullFilePath = "/cloud/technicain/$technicain_id/documents/$post->id/$fileName";
                $img->move($userdir . "/$post->id", $fileName);

                // create image post record
                PostImage::create([
                    'post_id' => $post->id,
                    'image' => $fullFilePath
                ]);
            }
        }


        return Controller::jsonMessage('تم النشر بنجاح', 0);
    }

    /**
     * Add new comment sent by a technicain and save it 
     * Data sent: id of the technicain, post-id of the post and the comment for the post
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

        $technicain = Technicain::find(Auth::guard($this->guard)->user()->id);
        $postComment = PostComment::create([
            'post_id' => $request->input('post-id'),
            'owner_id' => $technicain->id,
            'owner_type' => get_class($technicain),
            'comment' => $request->input('comment')
        ]);

        return response()->json(Controller::jsonMessage('تم اضافة تعليقك بنجاح', 0));
    }

    /**
     * Summary of deleteComment
     * UI Only
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function deleteComment(Request $request, $id)
    {
        $comment = PostComment::find($id);

        if ($comment->owner->id == Auth::guard($this->guard)->user()->id)
            $comment->delete();
        else
            return redirect()->back()->withErrors(['access-denied', 'طلب غير مسموح به']);
        return redirect()->back()->with('task-complet', 'تم حذف تعليقك بنجاح');
    }

    public function reservation(Request $request, $state, $id)
    {
        $reservation = Reservation::find($id);
        if ($reservation == null || ($state != 'Accepted' && $state != 'Refused')) {
            return redirect('/technicain');
        }

        $reservation->state = $state;
        $reservation->save();

        $customer = $reservation->customer();
        $data = [
            'from' => 'technicain',
            'customer' => $customer,
            'technicain' => $reservation->technicain(),
            'date' => $reservation->date,
            'id' => $reservation->id,
            'state' => $state,
            'url' => $url = request()->getSchemeAndHttpHost()
        ];
        Mail::to($customer->email)->send(new \App\Mail\ReservationEmail($data));
        return redirect('/technicain')->with('task-complet', $state == 'Accepted' ? "تم قبول الحجز" : "تم رفض الحجز");
    }


    public function editPostContent(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if ($v->failed()) {
            return Controller::jsonMessage('محتوى المنشور مطلوب', 1);
        }

        $technicain_id = Auth::guard($this->guard)->user()->id;

        $text = $request->input('text'); // post text
        $files = explode(",", $request->input('files-list')); // comma separated string of files sent
        // get the post
        $post = Post::find($id);
        if (!$post) {
            return Controller::jsonMessage('المنشور غير موجود', 1);
        }
        // modify post description text. save done
        $post->description = $text;
        $post->save();
        // post folder
        $userdir = public_path() . "/cloud/technicain/$technicain_id/documents";
        // remove old media files
        foreach ($post->media as $media) {
            $media->delete();
        }
        // place new uploaded files
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $img = $request->file($file);

                $fileName = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $img->getClientOriginalName());
                //$sanitizedFilename = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $originalName);
                $fullFilePath = "/cloud/technicain/$technicain_id/documents/$post->id/$fileName";
                $img->move($userdir . "/$post->id", $fileName);

                // create image post record
                PostImage::create([
                    'post_id' => $post->id,
                    'image' => $fullFilePath
                ]);
            }
        }


        return Controller::jsonMessage('تم الحفظ بنجاح', 0);
    }

    public function setReservationState(Request $request, $id, $state)
    {
        $reservation = Reservation::find($id);
        if ($reservation == null || ($state != 'InProgress' && $state != 'Done')) {
            return redirect('/technicain/scheduled-work')->withErrors(['reservation-unknown' => 'الحجز المطلوب غير موجود']);
        }

        $reservation->state = $state;
        $reservation->save();

        return redirect('/technicain/scheduled-work')->with('task-complet', " تم تغيير حالة الحجز بنجاح");
    }


    public function takeBreake(Request $request)
    {
        $technicain = Technicain::find(Auth::guard($this->guard)->user()->id);
        $technicain->state = "Paused";
        $technicain->save();

        return Controller::jsonMessage("تم تغيير حالة حسابك بنجاح ", 0);
    }

    public function backToBusiness(Request $request)
    {
        // Active only if sub is ok!
        $technicain = Technicain::find(Auth::guard($this->guard)->user()->id);
        if ($technicain->subscriptionCheck()) {
            $technicain->state = "Active";
            $technicain->save();

            return Controller::jsonMessage("تم تفعيل الحساب من جديد", 0);
        } else {
            return Controller::jsonMessage("حسابك غير مفعل. يرجى الاشتراك حتى تتمكن من تفعيله من جديد", 1);
        }
    }
}
