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
            width: 50%;     min-width: 15em;
            max-width: 25em;
            background-color: beige;
            border-radius: 1em;
            border: 1px solid darkgray;
            text-align: center;
        }

        .align-text {
            text-indent:30px;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
        }
        .no-data-section {
            margin: 0 auto; width:80%; text-align:center;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top:2em;
            background-color: #3e84e6;
            border-radius: 1em;
            border: 1px solid darkgray;
            min-width: 15em;
            max-width: 35em;
        }
    </style>


</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar")
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
                <h1 class="title" style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">المحفظة</h1>
                <div>
                    <div class="balance-box">
                        <h2 style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif"> 
                            @if($me->state == 'Inactive')
                            انت غير مشترك
                           
                            @else
                            انت مشترك وتاريخ انتهاء صلاحية الاشتراك
                            {{$me->wallet->lastOutgoingTransactions()->due}}
                            @endif
                        </h2>
                    </div>
                    <div style="margin: 0 auto; width:60%">
                        <form id="form_topup" action="/technicain/subscripe" method="post">
                            @csrf
                        <h5 class="align-text">الاشتراك</h5>
                        <p class="align-text">
                        تكلفة الاشتراك شهريا 15 د.ل
                            عند الاشتراك لايمكنك الغاء الامر.
                            
                        </p>
                        <div class="{{$me->state == 'Active' ? 'ux-input2 btn disabled' : 'ux-input2 btn success'}}" onclick="form_topup.submit()">
                            اشتراك
                        </div>
                        </form>
                    </div>

                    @if($me->wallet->outgoingTransactions()->count() > 0)
                    <table style="margin-top: 2em;">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                            <th>انتهاء الصلاحية</th>
                        </tr>
                        @foreach ($me->wallet->outgoingTransactions() as $t)
                            @if($t->type != 'Sub') 
                                @continue
                            @endif
                        <tr>
                            <td>{{$t->id}}</td>
                            <td>{{$me->fullname}}</td>
                            <td>{{$t->money}} د.ل</td>
                            <td>{{$t->created_at}}</td>
                            <td>{{$t->due}}</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <div  class="no-data-section">
                    <h3>لم تقم بأي اشتراك حتى الان</h3>
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
            timer: 1500,
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