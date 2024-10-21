<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Subscription</title>

    <link rel="stylesheet" href="/sources/main.css">
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">

    <link rel="stylesheet" href="/sources/technicain/css/mycustomers.css">
    <link rel="stylesheet" href="/sources/technicain/css/image-stack.css">

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    <link rel="stylesheet" href="/sources/technicain/css/posts.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <style>
        .error-card {
            width: 95%;
            margin: 0 auto;
            background-color: rgb(216, 32, 32);
            border-radius: 0.5em;
            padding: 0.5em;
            box-sizing: border-box;
            color: white;
            opacity: 1;
            transition: opacity 1s ease-in-out 5s;
        }

        .hide-now {
            opacity: 0;
        }

        .balance-box {
            margin: 0 auto;
            width: 50%;
            min-width: 15em;
            max-width: 25em;
            background-color: beige;
            border-radius: 1em;
            border: 1px solid darkgray;
            text-align: center;
        }

        .align-text {
            text-indent: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
        }

        .no-data-section {
            margin: 0 auto;
            width: 80%;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 2em;
            background-color: #3e84e6;
            border-radius: 1em;
            border: 1px solid darkgray;
            min-width: 15em;
            max-width: 35em;
        }
    </style>


</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " اعمالي الحالية"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width">
                <div class="profile-headblock">
                    <div class="cover" style='background-image: url({{ ($me->cover != "" && $me->cover != null) ? "/cloud/technicain/$me->id/images/$me->cover" : "/sources/img/cover.jpg"}})'>

                        <div class="edit" onclick="changeCoverImageProcessor()"></div>

                    </div>
                    <div class="pic" style='background-image: url( {{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/technicain/$me->id/images/$me->profile"}});'>

                        <div class="pic-hover-content" onclick="changeProfileImageProcessor()">
                            تغيير
                        </div>

                    </div>
                    <div class="name">{{$me->fullname}}</div>
<!-- 
                    <div class="rate-block">
                        <img src="https://img.icons8.com/?size=100&id=19417&format=png&color=000000">
                        <i>3.6</i>
                        <i>تقييم</i>
                    </div> -->

                </div>
            </div>
            <div class="md-grid-item full-width" dir="rtl">
                <h1 class="title" style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">جدول الاعمال</h1>
                <div>
                    @if($reservations->count() > 0)
                    <table class="green-table">
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>الزبون</th>
                            <th>العنوان</th>
                            <th>رقم الهاتف</th>
                            <th>الحاله</th>
                            <th>تاريخ الحجز</th>
                            <th>تاريخ التسجيل</th>
                            <th></th>
                        </tr>
                        @foreach ($reservations as $r)
                        @php
                        $customer = $r->customer();
                        $stateColor = 'black';

                        if($r->state == 'Done')
                        $stateColor = 'blue';
                        else if($r->state == 'Refused')
                        $stateColor = 'red';
                        else if($r->state == 'Accepted')
                        $stateColor = 'orange';
                        else if($r->state == 'InPrograess')
                        $stateColor = 'green';
                        @endphp
                        <tr>
                            <td>{{$r->id}}</td>
                            <td>
                                <div class="profile-stack-container m">
                                    <img src="{{($customer->profile == "Male.jpg" || $customer->profile == "Female.jpg") ? "/sources/img/$customer->profile" : "/cloud/customer/$customer->id/images/$customer->profile"}}" alt="">
                                </div>
                            </td>
                            <td>{{$customer->fullname}}</td>
                            <td>{{$customer->address}}</td>
                            <td>{{$customer->phone}}</td>
                            <td style="color:{{$stateColor}}">{{$r->sweetStateName()}}</td>
                            <td>{{$r->date}}</td>
                            <td>{{$r->created_at}}</td>
                            <td>
                                @if($r->state == 'Accepted')
                                <a href="/technicain/reservation-level/{{$r->id}}/InProgress" class="login-btn" style="background-color: Green;">
                                     تحديد كـ قيد العمل
                                </a>
                                @elseif($r->state == 'InProgress')
                                <a href="/technicain/reservation-level/{{$r->id}}/Done" class="login-btn" style="background-color: blue;">
                                     تحديد كـ مكتمل 
                                </a>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </table>
                    {{ $reservations->links() }}
                    @else
                    <div class="no-data-section">
                        <h3>لا توجد أي حجوزات حتى الان</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>


    <dialog id="add-post-dialog" class="fullscreen-dialog">
        <div class="topbar-container">
            <div class="close" onclick="showDialog()"></div>
            <div class="title">اضافة منشور</div>
        </div>
        <div class="container" style="overflow-y:auto">
            <div class="md-grid-container">
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em; background-color:rgba(244,244,244);">
                    <b class="title">نص المنشور</b>
                    <div>
                        <textarea onchange="" name="techincain-add-post-textarea" id="techincain-add-post-textarea" class="post-textarea"></textarea>
                    </div>
                </div>
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em;  background-color:rgba(244,244,244);">
                    <b class="title">صور وفيديوهات المنشور</b>
                    <button id="techincain-add-post-addmedia" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=IA4hgI5aWiHD&format=png&color=000000" alt="">
                        <i>اضافة</i>
                    </button>
                    <div id="techincain-add-post-imagelist" style="height:20em; padding:0.2em;white-space: nowrap;overflow-x:scroll;overflow-y:hidden;">
                    </div>
                </div>
            </div>
            <div class="md-grid-container md-grid-item full-width" style="background-color: transparent; border:none;">
                <div class="md-grid-item full-width full-height" style="border-radius: 1em; padding-bottom:1em;">
                    <b class="title">للنشر اضغط على زر النشر ادناه</b>
                    <button id="techincain-add-post-submit" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=103205&format=png&color=000000" alt="">
                        <i>نشر</i>
                    </button>
                </div>
            </div>
        </div>
    </dialog>

    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>



    <script src="/sources/technicain/js/posts.js"></script>


    @include('successful-task');

    <!-- For Regular Errors -->
    @if($errors->any())
    @foreach ($errors->all() as $err)
    <script>
        Swal.fire({
            toast: true,
            icon: "error",
            title: 'مشكلة في العملية',
            text: "{{$err}}",
            position: "top-end",
            showConfirmButton: false,
            timer: 1700,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },

            didClose: () => {
                location.reload();
            }
        });
    </script>
    @endforeach
    @endif
    @if($me->profile == 'Male.jpg' || $me->profile == 'Female.jpg')
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: "يرجى تغيير الصورة الشخصية حتى تتكمن من تفعيل خدمات حسابك"
        });
    </script>
    @endif
    <script>
        setTimeout(() => {
            let errCard = document.querySelector('.error-card');
            if (errCard == null) return;
            errCard.addEventListener("transitionend", (event) => {
                errCard.remove();
            });
            errCard.classList.add('hide-now');
        }, 1000);
    </script>
</body>

</html>




<!--


<div class="md-grid-item half-width" style="border-radius: 1em;">
                <b class="title">جدول الاعمال الحالي</b>
                <div>
                    <table class="calendar">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                                <td>13</td>
                                <td>14</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>16</td>
                                <td>17</td>
                                <td>18</td>
                                <td>19</td>
                                <td>20</td>
                                <td>21</td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td>23</td>
                                <td>24</td>
                                <td>25</td>
                                <td>26</td>
                                <td>27</td>
                                <td>28</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>30</td>
                                <td>31</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>


-->